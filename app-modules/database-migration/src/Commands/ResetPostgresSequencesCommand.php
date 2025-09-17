<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class ResetPostgresSequencesCommand extends Command
{
    protected $signature = 'db:reset-sequences {--dry-run : Show what would be reset without executing}';

    protected $description = 'Reset PostgreSQL sequences to match current MAX(id) values';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No sequences will be actually reset');
        }

        $this->info('🔄 Resetting PostgreSQL sequences...');
        $this->newLine();

        $tablesWithSequences = $this->getTablesWithSequences();

        if ($tablesWithSequences->isEmpty()) {
            $this->warn('❌ No tables with sequences found');

            return Command::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar($tablesWithSequences->count());
        $progressBar->start();

        $resetCount = 0;
        $skipCount = 0;

        foreach ($tablesWithSequences as $sequenceInfo) {
            try {
                $tableName = $sequenceInfo->table_name;
                $sequenceName = $sequenceInfo->sequence_name;
                $columnName = $sequenceInfo->column_name;

                $maxId = DB::table($tableName)->max($columnName) ?? 0;
                $nextVal = $maxId + 1;

                if ($isDryRun) {
                    $this->line("Would reset {$sequenceName} to {$nextVal} (max {$columnName}: {$maxId})");
                } else {
                    DB::statement('SELECT setval(?, GREATEST(?, 1))', [$sequenceName, $nextVal]);
                }

                $resetCount++;
            } catch (\Exception $e) {
                $this->line("⚠️  Skipped {$sequenceInfo->table_name}: {$e->getMessage()}");
                $skipCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        if ($isDryRun) {
            $this->info("✅ Dry run completed - {$resetCount} sequences would be reset, {$skipCount} skipped");
        } else {
            $this->info("✅ Sequences reset completed - {$resetCount} reset, {$skipCount} skipped");
        }

        return Command::SUCCESS;
    }

    private function getTablesWithSequences(): Collection
    {
        try {
            $result = DB::select("
                SELECT
                    t.relname AS table_name,
                    a.attname AS column_name,
                    s.relname AS sequence_name
                FROM pg_class s
                JOIN pg_depend d ON d.objid = s.oid
                JOIN pg_class t ON d.refobjid = t.oid
                JOIN pg_attribute a ON (d.refobjid, d.refobjsubid) = (a.attrelid, a.attnum)
                JOIN pg_namespace n ON n.oid = s.relnamespace
                WHERE s.relkind = 'S'
                  AND d.deptype = 'a'
                  AND t.relkind = 'r'
                  AND n.nspname = 'public'
                ORDER BY t.relname, a.attname
            ");

            return collect($result);
        } catch (\Exception $e) {
            $this->warn("Error querying sequences: {$e->getMessage()}");

            return collect();
        }
    }
}
