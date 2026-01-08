<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Tables with public_id
    |--------------------------------------------------------------------------
    |
    | List of tables that should have a public_id UUID generated during
    | migration. These ordered UUIDs will be automatically generated for
    | each record during the migration process.
    |
    */
    'tables_with_public_id' => [
        'users',
        'articles',
        'discussions',
        'threads',
        'replies',
        'channels',
        'tags',
        'activities',
        'enterprises',
        'plans',
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Tables
    |--------------------------------------------------------------------------
    |
    | List of tables that should not be migrated. These are typically
    | system or temporary tables that don't need to be migrated to
    | the new database.
    |
    */
    'excluded_tables' => [
        'migrations',
        'password_resets',
        'personal_access_tokens',
        'failed_jobs',
        'jobs',
        'job_batches',
        'temporary_uploads',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Connections used for migration. The source connection is used to
    | read MySQL data and the target connection to write PostgreSQL data.
    |
    */
    'source_connection' => env('DB_MIGRATION_SOURCE_CONNECTION', 'secondary'),
    'target_connection' => env('DB_MIGRATION_TARGET_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Chunk Settings
    |--------------------------------------------------------------------------
    |
    | Default chunk size for processing records during migration.
    | Larger sizes improve performance but consume more memory.
    |
    */
    'default_chunk_size' => env('DB_MIGRATION_CHUNK_SIZE', 1000),
];
