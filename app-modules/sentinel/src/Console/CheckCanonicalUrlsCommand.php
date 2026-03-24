<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Laravelcm\Sentinel\Contracts\Scannable;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;
use Throwable;

final class CheckCanonicalUrlsCommand extends Command
{
    protected $signature = 'sentinel:check-canonicals';

    protected $description = 'Check that canonical URLs on articles are still accessible';

    public function handle(): int
    {
        $appUrl = config('app.url');
        $appHost = is_string($appUrl) ? parse_url($appUrl, PHP_URL_HOST) : null;

        /** @var array<int, class-string<Model>> $models */
        $models = config('sentinel.models', []);
        $broken = 0;

        foreach ($models as $modelClass) {
            $name = class_basename($modelClass);

            $modelClass::query()->each(function (Model $model) use ($appHost, $name, &$broken): void {
                if (! $model instanceof Scannable) {
                    return;
                }

                $canonicalUrl = $model->sentinelCanonicalUrl();

                if ($canonicalUrl === null || $canonicalUrl === '') {
                    return;
                }

                $canonicalHost = parse_url($canonicalUrl, PHP_URL_HOST);

                if ($canonicalHost === $appHost) {
                    return;
                }

                \Illuminate\Support\Sleep::usleep(500_000);

                try {
                    $response = Http::retry(2, 1000)->timeout(10)->head($canonicalUrl);

                    if ($response->status() === 405) {
                        $response = Http::retry(2, 1000)->timeout(10)->get($canonicalUrl);
                    }

                    if ($response->status() >= 400) {
                        $this->recordIssue($model, $canonicalUrl, $response->status());
                        $broken++;
                        $id = (int) $model->getKey(); // @phpstan-ignore cast.int
                        $this->line(sprintf('  [%s #%d] %s → %d', $name, $id, $canonicalUrl, $response->status()));
                    }
                } catch (Throwable) {
                    $this->recordIssue($model, $canonicalUrl, 0);
                    $broken++;
                    $id = (int) $model->getKey(); // @phpstan-ignore cast.int
                    $this->line(sprintf('  [%s #%d] %s → unreachable', $name, $id, $canonicalUrl));
                }
            });
        }

        $this->components->info($broken.' broken canonical URL(s) found.');

        return self::SUCCESS;
    }

    private function recordIssue(Model&Scannable $model, string $canonicalUrl, int $statusCode): void
    {
        ContentIssue::query()->firstOrCreate(
            [
                'issueable_id' => $model->getKey(),
                'issueable_type' => $model->getMorphClass(),
                'type' => IssueType::BrokenCanonical,
                'status' => IssueStatus::Detected,
            ],
            [
                'details' => [
                    'canonical_url' => $canonicalUrl,
                    'status_code' => $statusCode,
                ],
                'detected_at' => now(),
            ],
        );
    }
}
