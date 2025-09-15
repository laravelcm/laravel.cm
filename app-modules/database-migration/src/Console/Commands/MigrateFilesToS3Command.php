<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

final class MigrateFilesToS3Command extends Command
{
    protected $signature = 'files:migrate-to-s3
                            {--target-disk=s3 : Target S3 disk name}
                            {--dry-run : Show what would be migrated without actually doing it}
                            {--chunk=100 : Number of files to process per chunk}';

    protected $description = 'Migrate local files from public/media and storage/app/public to S3 storage';

    private int $totalFiles = 0;

    private int $processedFiles = 0;

    private int $failedFiles = 0;

    public function handle(): int
    {
        $this->info('🚀 Starting file migration to S3...');

        $targetDisk = (string) $this->option('target-disk');
        $isDryRun = $this->option('dry-run');
        /** @var int<1, max> $chunkSize */
        $chunkSize = max(1, (int) $this->option('chunk'));

        // Verify S3 disk configuration
        if (! $this->verifyS3Configuration($targetDisk)) {
            return Command::FAILURE;
        }

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No files will be actually migrated');
        }

        try {
            $sourceDirs = $this->getSourceDirectories();

            foreach ($sourceDirs as $sourceDir) {
                $this->info("📁 Processing directory: {$sourceDir['path']}");
                $this->migrateDirectory($sourceDir, $targetDisk, $chunkSize, $isDryRun);
            }

            $this->displaySummary();

            if ($isDryRun) {
                $this->info('✅ Dry run completed successfully');
            } else {
                $this->info('✅ File migration completed successfully');
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Migration failed: {$e->getMessage()}");

            return Command::FAILURE;
        }
    }

    private function verifyS3Configuration(string $disk): bool
    {
        try {
            $config = config("filesystems.disks.{$disk}");

            if (! $config) {
                $this->error("❌ Disk '{$disk}' not found in configuration");

                return false;
            }

            if ($config['driver'] !== 's3') {
                $this->error("❌ Disk '{$disk}' is not an S3 disk");

                return false;
            }

            // Test S3 connection
            Storage::disk($disk)->files('');
            $this->info("✅ S3 disk '{$disk}' is properly configured");

            return true;

        } catch (\Exception $e) {
            $this->error("❌ S3 configuration error: {$e->getMessage()}");

            return false;
        }
    }

    private function getSourceDirectories(): array
    {
        return [
            [
                'path' => public_path('media'),
                's3_prefix' => '',
                'name' => 'Media Library (public/media)',
            ],
            [
                'path' => storage_path('app/public'),
                's3_prefix' => '',
                'name' => 'Public Storage (storage/app/public)',
            ],
        ];
    }

    private function migrateDirectory(array $sourceDir, string $targetDisk, int $chunkSize, bool $isDryRun): void
    {
        if (! File::exists($sourceDir['path'])) {
            $this->warn("⚠️  Directory does not exist: {$sourceDir['path']}");

            return;
        }

        $finder = new Finder;
        $files = $finder->files()->in($sourceDir['path']);

        $fileList = iterator_to_array($files);
        $totalFiles = count($fileList);
        $this->totalFiles += $totalFiles;

        if ($totalFiles === 0) {
            $this->info("📂 No files found in {$sourceDir['name']}");

            return;
        }

        $this->info("📊 Found {$totalFiles} files in {$sourceDir['name']}");

        $progressBar = $this->output->createProgressBar($totalFiles);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start();

        // @phpstan-ignore-next-line
        $chunks = array_chunk($fileList, $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $file) {
                $this->migrateFile($file, $sourceDir, $targetDisk, $isDryRun);
                $progressBar->advance();
            }
        }

        $progressBar->finish();
        $this->newLine();
    }

    private function migrateFile(\SplFileInfo $file, array $sourceDir, string $targetDisk, bool $isDryRun): void
    {
        try {
            $relativePath = str_replace($sourceDir['path'].'/', '', $file->getPathname());

            // Get the root directory from S3 disk configuration
            $diskConfig = config("filesystems.disks.{$targetDisk}");
            $rootDir = $diskConfig['root'] ?? 'public';

            // Build S3 path: root/relativePath (without additional prefix)
            $s3Path = $rootDir.'/'.$relativePath;

            if ($isDryRun) {
                $this->processedFiles++;

                return;
            }

            // Upload to S3
            $fileContent = File::get($file->getPathname());
            $uploaded = Storage::disk($targetDisk)->put($s3Path, $fileContent, 'public');

            if ($uploaded) {
                $this->processedFiles++;
            } else {
                $this->failedFiles++;
            }

        } catch (\Exception $e) {
            $this->failedFiles++;
            $this->line("   ❌ Error migrating {$file->getFilename()}: {$e->getMessage()}");
        }
    }

    private function displaySummary(): void
    {
        $this->newLine();
        $this->info('📊 Migration Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total files found', $this->totalFiles],
                ['Successfully processed', $this->processedFiles],
                ['Failed', $this->failedFiles],
                ['Success rate', $this->totalFiles > 0 ? round(($this->processedFiles / $this->totalFiles) * 100, 2).'%' : '0%'],
            ]
        );

        if ($this->failedFiles > 0) {
            $this->warn("⚠️  {$this->failedFiles} files failed to migrate. Check the logs above for details.");
        }
    }
}
