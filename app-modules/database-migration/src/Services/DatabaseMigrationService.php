<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseMigrationService
{
    private string $sourceConnection = 'secondary';

    private string $targetConnection = 'pgsql';

    /**
     * Get all tables from the source database
     *
     * @return array<string>
     */
    public function getSourceTables(): array
    {
        $tables = DB::connection($this->sourceConnection)
            ->select('SHOW TABLES');

        $tableColumn = 'Tables_in_'.DB::connection($this->sourceConnection)->getDatabaseName();

        return collect($tables)
            ->pluck($tableColumn)
            ->reject(fn ($table): bool => in_array($table, $this->getExcludedTables()))
            ->values()
            ->toArray();
    }

    /**
     * Get tables that should be excluded from migration
     *
     * @return array<string>
     */
    private function getExcludedTables(): array
    {
        return [
            'migrations',
            'password_resets',
            'password_reset_tokens',
            'personal_access_tokens',
            'failed_jobs',
            'jobs',
            'job_batches',
        ];
    }

    /**
     * Get the number of records in a table
     */
    public function getTableRecordCount(string $table): int
    {
        return DB::connection($this->sourceConnection)
            ->table($table)
            ->count();
    }

    /**
     * Migrate a single table from source to target
     */
    public function migrateTable(string $table, int $chunkSize = 1000, ?callable $progressCallback = null): void
    {
        // First, ensure the table exists in target database
        if (! Schema::connection($this->targetConnection)->hasTable($table)) {
            throw new \Exception("Table '{$table}' does not exist in target database. Run migrations first.");
        }

        // Clear existing data in target table
        DB::connection($this->targetConnection)->table($table)->truncate();

        $totalRecords = $this->getTableRecordCount($table);
        $processedRecords = 0;

        // Process data in chunks
        DB::connection($this->sourceConnection)
            ->table($table)
            ->orderBy('id')
            ->chunk($chunkSize, function (Collection $records) use (
                $table,
                &$processedRecords,
                $totalRecords,
                $progressCallback
            ): void {
                $data = $records->map(fn ($record): array => $this->transformRecord((array) $record))->toArray();

                // Insert into target database
                DB::connection($this->targetConnection)
                    ->table($table)
                    ->insert($data);

                $processedRecords += count($records);

                if ($progressCallback) {
                    $progressCallback($processedRecords, $totalRecords);
                }
            });
    }

    /**
     * Transform a record for PostgreSQL compatibility
     *
     * @param  array<string, mixed>  $record
     * @return array<string, mixed>
     */
    private function transformRecord(array $record): array
    {
        foreach ($record as $key => $value) {
            // Handle MySQL boolean fields (tinyint) to PostgreSQL boolean
            if (is_int($value) && in_array($value, [0, 1]) && preg_match('/^(is_|has_|can_|should_|enabled|active|published|verified)/', $key)) {
                $record[$key] = (bool) $value;
            }

            // Handle empty strings that should be null in PostgreSQL
            if ($value === '') {
                $record[$key] = null;
            }

            // Handle MySQL timestamp '0000-00-00 00:00:00' to null
            if ($value === '0000-00-00 00:00:00') {
                $record[$key] = null;
            }
        }

        return $record;
    }

    /**
     * Verify migration by comparing record counts
     *
     * @return array<string, array{source: int, target: int, match: bool}>
     */
    public function verifyMigration(array $tables): array
    {
        $results = [];

        foreach ($tables as $table) {
            $sourceCount = $this->getTableRecordCount($table);
            $targetCount = DB::connection($this->targetConnection)
                ->table($table)
                ->count();

            $results[$table] = [
                'source' => $sourceCount,
                'target' => $targetCount,
                'match' => $sourceCount === $targetCount,
            ];
        }

        return $results;
    }

    /**
     * Test database connections
     */
    public function testConnections(): array
    {
        $results = [];

        try {
            DB::connection($this->sourceConnection)->getPdo();
            $results['source'] = true;
        } catch (\Exception $e) {
            $results['source'] = false;
            $results['source_error'] = $e->getMessage();
        }

        try {
            DB::connection($this->targetConnection)->getPdo();
            $results['target'] = true;
        } catch (\Exception $e) {
            $results['target'] = false;
            $results['target_error'] = $e->getMessage();
        }

        return $results;
    }
}
