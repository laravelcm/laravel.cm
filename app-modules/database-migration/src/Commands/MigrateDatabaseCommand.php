<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Commands;

use Illuminate\Console\Command;
use Laravelcm\DatabaseMigration\Services\DatabaseMigrationService;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

final class MigrateDatabaseCommand extends Command
{
    protected $signature = 'db:migrate-mysql-to-pgsql
                            {--tables=* : Specific tables to migrate (optional)}
                            {--chunk=1000 : Number of records to process per chunk}
                            {--dry-run : Show what would be migrated without actually doing it}';

    protected $description = 'Migrate data from MySQL to PostgreSQL with SSH tunnel support';

    public function handle(
        SshTunnelService $tunnelService,
        DatabaseMigrationService $migrationService
    ): int {
        $this->info('🚀 Starting MySQL to PostgreSQL migration...');

        // Ensure SSH tunnel is active
        if (! $tunnelService->isActive()) {
            $this->warn('SSH tunnel is not active. Attempting to activate...');
            $tunnelService->activate();
        }

        if (! $tunnelService->isActive()) {
            $this->error('❌ Failed to activate SSH tunnel. Migration aborted.');

            return Command::FAILURE;
        }

        $this->info('✅ SSH tunnel is active');

        $isDryRun = $this->option('dry-run');
        $chunkSize = (int) $this->option('chunk');
        $specificTables = $this->option('tables');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No data will be actually migrated');
        }

        try {
            // Get tables to migrate
            $tables = $specificTables ?: $migrationService->getSourceTables();

            if (blank($tables)) {
                $this->error('❌ No tables found to migrate');

                return Command::FAILURE;
            }

            $this->info(sprintf('📋 Found %d tables to migrate', count($tables)));

            $progressBar = $this->output->createProgressBar(count($tables));
            $progressBar->start();

            foreach ($tables as $table) {
                if ($table === null) {
                    continue;
                }

                $this->newLine();
                $this->info("🔄 Migrating table: {$table}");

                if (! $isDryRun) {
                    $migrationService->migrateTable($table, $chunkSize, function ($processed, $total): void {
                        $this->line("   📊 Processed {$processed}/{$total} records");
                    });
                } else {
                    $count = $migrationService->getTableRecordCount($table);
                    $this->line("   📊 Would migrate {$count} records");
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);

            if ($isDryRun) {
                $this->info('✅ Dry run completed successfully');
            } else {
                $this->info('✅ Migration completed successfully');
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Migration failed: {$e->getMessage()}");

            return Command::FAILURE;
        }
    }
}
