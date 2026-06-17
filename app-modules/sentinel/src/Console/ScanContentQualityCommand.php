<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Sentinel\Actions\ScanContentAction;
use Laravelcm\Sentinel\Contracts\Scannable;

#[\Illuminate\Console\Attributes\Description('Scan content for quality issues (broken links, missing https, failed uploads)')]
#[\Illuminate\Console\Attributes\Signature('sentinel:scan')]
final class ScanContentQualityCommand extends Command
{
    public function handle(ScanContentAction $action): int
    {
        $totalIssues = 0;

        /** @var array<int, class-string<Model>> $models */
        $models = config('sentinel.models', []);

        foreach ($models as $modelClass) {
            $name = class_basename($modelClass);

            $modelClass::query()->each(function (Model $model) use ($action, &$totalIssues, $name): void {
                if (! $model instanceof Scannable) {
                    return;
                }

                $issues = $action->execute($model);

                if ($issues !== []) {
                    $totalIssues += count($issues);
                    $id = (int) $model->getKey(); // @phpstan-ignore cast.int
                    $this->line(sprintf('  [%s #%d] ', $name, $id).count($issues).' issue(s) detected');
                }
            });

            $this->components->info($name.' scan complete.');
        }

        $this->newLine();
        $this->components->info('Total issues detected: '.$totalIssues);

        return self::SUCCESS;
    }
}
