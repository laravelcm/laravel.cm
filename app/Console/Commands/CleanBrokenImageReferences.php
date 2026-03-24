<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

final class CleanBrokenImageReferences extends Command
{
    protected $signature = 'app:clean-broken-images {--dry-run : Show what would be cleaned without making changes}';

    protected $description = 'Remove broken /storage/images/ markdown references from content';

    /** @var array<class-string<Model>> */
    private array $models = [
        Article::class,
        Thread::class,
        Discussion::class,
        Reply::class,
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->components->warn('Dry-run mode — no changes will be made.');
        }

        $totalCleaned = 0;
        $totalRefs = 0;

        foreach ($this->models as $model) {
            [$cleaned, $refs] = $this->cleanModel($model, $dryRun);
            $totalCleaned += $cleaned;
            $totalRefs += $refs;
        }

        $this->newLine();

        if ($dryRun) {
            $this->components->info(sprintf('Would clean %d image references in %d records.', $totalRefs, $totalCleaned));
        } else {
            $this->components->info(sprintf('Cleaned %d image references in %d records.', $totalRefs, $totalCleaned));
        }

        return self::SUCCESS;
    }

    /**
     * @param  class-string<Model>  $model
     * @return array{int, int}
     */
    private function cleanModel(string $model, bool $dryRun): array
    {
        $name = class_basename($model);
        $records = $model::query()->where('body', 'like', '%/storage/images/%')->get();

        if ($records->isEmpty()) {
            $this->components->info($name.': no broken references found.');

            return [0, 0];
        }

        $cleaned = 0;
        $totalRefs = 0;

        foreach ($records as $record) {
            $original = $record->body; // @phpstan-ignore-line

            // Remove markdown images: ![alt text](/storage/images/...)
            $cleanedBody = (string) preg_replace(
                '/!\[[^\]]*\]\(\s*\/storage\/images\/[^)]+\)\s*/',
                '',
                $original
            );

            // Count removed references
            preg_match_all('/!\[[^\]]*\]\(\s*\/storage\/images\/[^)]+\)/', $original, $matches);
            $refCount = count($matches[0]);

            if ($cleanedBody !== $original) {
                $totalRefs += $refCount;
                $cleaned++;

                if ($dryRun) {
                    $this->line(sprintf('  [%s #%s] %d image(s) would be removed', $name, $record->id, $refCount)); // @phpstan-ignore-line
                } else {
                    $record->updateQuietly(['body' => $cleanedBody]);
                    $this->line(sprintf('  [%s #%s] %d image(s) removed', $name, $record->id, $refCount)); // @phpstan-ignore-line
                }
            }
        }

        $this->components->info(sprintf('%s: %d references in %d records', $name, $totalRefs, $cleaned).($dryRun ? ' (dry-run)' : ' cleaned'));

        return [$cleaned, $totalRefs];
    }
}
