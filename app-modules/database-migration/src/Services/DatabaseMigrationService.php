<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Services;

use Exception;
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
        $tables = DB::connection($this->sourceConnection)->select('SHOW TABLES');

        $tableColumn = 'Tables_in_'.DB::connection($this->sourceConnection)->getDatabaseName();

        return collect($tables)
            ->pluck($tableColumn)
            ->reject(fn (string $table): bool => in_array($table, $this->getExcludedTables()))
            ->values()
            ->toArray();
    }

    public function getTableRecordCount(string $table): int
    {
        return DB::connection($this->sourceConnection)
            ->table($table)
            ->count();
    }

    public function migrateTable(string $table, int $chunkSize = 1000, ?callable $progressCallback = null): void
    {
        if (! Schema::connection($this->targetConnection)->hasTable($table)) {
            return;
        }

        DB::connection($this->targetConnection)->table($table)->truncate();

        $totalRecords = $this->getTableRecordCount($table);
        $processedRecords = 0;

        $query = DB::connection($this->sourceConnection)->table($table);

        if ($this->hasIdColumn($table)) {
            $query->orderBy('id');
        } else {
            $columns = Schema::connection($this->sourceConnection)->getColumnListing($table);

            if (filled($columns)) {
                $query->orderBy($columns[0]);
            }
        }

        $query->chunk($chunkSize, function (Collection $records) use (
            $table,
            &$processedRecords,
            $totalRecords,
            $progressCallback
        ): void {
            $data = $records->map(fn (object $record): array => $this->transformRecord((array) $record))->all();

            DB::connection($this->targetConnection)
                ->table($table)
                ->insert($data);

            $processedRecords += count($records);

            if ($progressCallback !== null) {
                $progressCallback($processedRecords, $totalRecords);
            }
        });
    }

    public function disableForeignKeyConstraints(): void
    {
        DB::connection($this->targetConnection)
            ->statement('SET session_replication_role = replica;');
    }

    public function enableForeignKeyConstraints(): void
    {
        DB::connection($this->targetConnection)
            ->statement('SET session_replication_role = DEFAULT;');
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
        } catch (Exception $exception) {
            $results['source'] = false;
            $results['source_error'] = $exception->getMessage();
        }

        try {
            DB::connection($this->targetConnection)->getPdo();
            $results['target'] = true;
        } catch (Exception $exception) {
            $results['target'] = false;
            $results['target_error'] = $exception->getMessage();
        }

        return $results;
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
            'personal_access_tokens',
            'failed_jobs',
            'jobs',
            'job_batches',
            'temporary_uploads',
        ];
    }

    private function hasIdColumn(string $table): bool
    {
        return Schema::connection($this->sourceConnection)->hasColumn($table, 'id');
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
            if (is_int($value) && in_array($value, [0, 1]) && preg_match('/^(is_|has_|can_|should_|enabled|active|certified|public|featured|published|pinned|opt_in|sponsored|verified|locked)/', $key)) {
                $record[$key] = (bool) $value;
            }

            // Handle MySQL timestamp '0000-00-00 00:00:00' to null
            if ($value === '0000-00-00 00:00:00') {
                $record[$key] = null;
            }
        }

        return $record;
    }
}
