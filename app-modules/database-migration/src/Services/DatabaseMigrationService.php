<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Services;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseMigrationService
{
    private string $sourceConnection;

    private string $targetConnection;

    private string $currentTable = '';

    public function __construct()
    {
        $this->sourceConnection = config('database-migration.source_connection', 'secondary');
        $this->targetConnection = config('database-migration.target_connection', 'pgsql');
    }

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

        $this->currentTable = $table;

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
        return config('database-migration.excluded_tables', [
            'migrations',
            'password_resets',
            'personal_access_tokens',
            'failed_jobs',
            'jobs',
            'job_batches',
            'temporary_uploads',
        ]);
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
        // Generate public_id UUID if the table requires it and the column exists in target
        if ($this->shouldGeneratePublicId() && ! isset($record['public_id'])) {
            $record['public_id'] = $this->generateOrderedUuid();
        }

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

    /**
     * Check if the current table should have public_id generated
     */
    private function shouldGeneratePublicId(): bool
    {
        if (blank($this->currentTable)) {
            return false;
        }

        /** @var array<string> $tablesWithPublicId */
        $tablesWithPublicId = config('database-migration.tables_with_public_id', []);

        if (! in_array($this->currentTable, $tablesWithPublicId)) {
            return false;
        }

        // Verify that the target table has the public_id column
        return Schema::connection($this->targetConnection)
            ->hasColumn($this->currentTable, 'public_id');
    }

    private function generateOrderedUuid(): string
    {
        return (string) Str::orderedUuid();
    }
}
