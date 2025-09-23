<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateStorageUrlsCommand extends Command
{
    protected $signature = 'db:update-storage-urls
                            {--dry-run : Show what would be updated without executing}
                            {--old-domain=https://laravel.cm/storage : Old storage domain to replace}
                            {--new-disk=media : New disk to use for URLs}';

    protected $description = 'Update old storage URLs to new S3 URLs in database content';

    private array $affectedTables = [
        'articles' => ['body'],
        'threads' => ['body'],
        'replies' => ['body'],
    ];

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        /** @var string $oldDomain */
        $oldDomain = $this->option('old-domain');
        /** @var string $newDisk */
        $newDisk = $this->option('new-disk');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No URLs will be actually updated');
        }

        $this->info('🔄 Updating storage URLs in database content...');
        $this->newLine();

        /** @var string $newBaseUrl */
        $newBaseUrl = $this->getNewBaseUrl($newDisk);

        if (! $newBaseUrl) {
            $this->error("❌ Could not determine base URL for disk: {$newDisk}");

            return Command::FAILURE;
        }

        $this->info("Old domain: {$oldDomain}");
        $this->info("New base URL: {$newBaseUrl}");
        $this->newLine();

        $totalUpdated = 0;
        $totalRecords = 0;

        foreach ($this->affectedTables as $table => $columns) {
            foreach ($columns as $column) {
                $records = $this->getRecordsWithOldUrls($table, $column, $oldDomain);
                $recordCount = $records->count();
                $totalRecords += $recordCount;

                if ($recordCount === 0) {
                    continue;
                }

                $this->info("📋 Processing {$table}.{$column} - {$recordCount} records found");

                $progressBar = $this->output->createProgressBar($recordCount);
                $progressBar->start();

                $updated = 0;
                foreach ($records as $record) {
                    $newContent = $this->updateUrlsInContent($record->$column, $oldDomain, $newBaseUrl);

                    if ($newContent !== $record->$column) {
                        if (! $isDryRun) {
                            DB::table($table)
                                ->where('id', $record->id)
                                ->update([$column => $newContent]);
                        }
                        $updated++;
                    }

                    $progressBar->advance();
                }

                $progressBar->finish();
                $this->newLine();

                if ($updated > 0) {
                    if ($isDryRun) {
                        $this->line("  Would update {$updated} records in {$table}.{$column}");
                    } else {
                        $this->line("  ✅ Updated {$updated} records in {$table}.{$column}");
                    }
                }

                $totalUpdated += $updated;
            }
        }

        $this->newLine();
        if ($isDryRun) {
            $this->info("✅ Dry run completed - {$totalUpdated} records would be updated out of {$totalRecords} total records with old URLs");
        } else {
            $this->info("✅ URL migration completed - {$totalUpdated} records updated out of {$totalRecords} total records with old URLs");
        }

        return Command::SUCCESS;
    }

    private function getNewBaseUrl(string $disk): ?string
    {
        try {
            $diskConfig = config("filesystems.disks.{$disk}");

            if (! $diskConfig) {
                return null;
            }

            if ($diskConfig['driver'] === 's3') {
                $baseUrl = '';

                if (isset($diskConfig['url']) && $diskConfig['url']) {
                    $baseUrl = rtrim($diskConfig['url'], '/');
                } else {
                    $bucket = $diskConfig['bucket'] ?? '';
                    $region = $diskConfig['region'] ?? '';
                    if ($bucket && $region) {
                        $baseUrl = "https://{$bucket}.s3.{$region}.amazonaws.com";
                    }
                }

                if ($baseUrl && isset($diskConfig['root']) && $diskConfig['root']) {
                    $root = trim($diskConfig['root'], '/');

                    if (filled($root)) {
                        $baseUrl .= '/'.$root;
                    }
                }

                return $baseUrl;
            }

            return Storage::disk($disk)->url('');
        } catch (\Exception $e) {
            $this->error("Error getting base URL for disk {$disk}: ".$e->getMessage());

            return null;
        }
    }

    private function getRecordsWithOldUrls(string $table, string $column, string $oldDomain): Collection
    {
        return collect(
            DB::table($table)
                ->select('id', $column)
                ->where($column, 'LIKE', "%{$oldDomain}%")
                ->get()
        );
    }

    private function updateUrlsInContent(string $content, string $oldDomain, string $newBaseUrl): string
    {
        // Pattern to match the old storage URLs
        // Example: https://laravel.cm/storage/ODvtYqlGsnpk9gn4hUNfBZfCw25CdlIrFL4GpooD.png
        $pattern = '#'.preg_quote($oldDomain, '#').'/([a-zA-Z0-9._-]+\.[a-zA-Z]{2,4})#';

        return (string) preg_replace_callback($pattern, function (array $matches) use ($newBaseUrl): string {
            $filename = $matches[1];

            return $newBaseUrl.'/'.$filename;
        }, $content);
    }
}
