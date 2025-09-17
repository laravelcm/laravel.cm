<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        $tables = collect(Schema::getTableListing())
            ->filter(fn (string $table): bool => Schema::hasColumn($table, 'id'))
            ->filter(fn (string $table): bool => $this->hasSequence($table));

        if ($tables->isEmpty()) {
            $this->warn('❌ No tables with sequences found');

            return Command::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar($tables->count());
        $progressBar->start();

        $resetCount = 0;
        $skipCount = 0;

        foreach ($tables as $table) {
            try {
                $maxId = DB::table($table)->max('id') ?? 0;

                if ($isDryRun) {
                    $this->line("Would reset {$table}_id_seq to {$maxId}");
                } else {
                    DB::statement("SELECT setval('{$table}_id_seq', COALESCE(MAX(id), 1)) FROM {$table};");
                }

                $resetCount++;
            } catch (\Exception $e) {
                $this->line("⚠️  Skipped {$table}: {$e->getMessage()}");
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

    private function hasSequence(string $table): bool
    {
        try {
            $result = DB::select("SELECT 1 FROM pg_class WHERE relname = '{$table}_id_seq' AND relkind = 'S'");

            return ! empty($result);
        } catch (\Exception) {
            return false;
        }
    }
}
