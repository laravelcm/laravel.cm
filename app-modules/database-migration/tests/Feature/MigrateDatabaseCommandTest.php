<?php

declare(strict_types=1);

use Laravelcm\DatabaseMigration\Services\DatabaseMigrationService;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

it('has migrate database command', function (): void {
    $this->artisan('db:migrate-mysql-to-pgsql --help')
        ->assertExitCode(0);
});

it('can run dry run migration', function (): void {
    // Mock the services
    $mockTunnelService = $this->mock(SshTunnelService::class);
    $mockTunnelService->shouldReceive('isActive')->andReturn(true);

    $mockMigrationService = $this->mock(DatabaseMigrationService::class);
    $mockMigrationService->shouldReceive('getSourceTables')
        ->andReturn(['users', 'articles']);
    $mockMigrationService->shouldReceive('getTableRecordCount')
        ->with('users')
        ->andReturn(100);
    $mockMigrationService->shouldReceive('getTableRecordCount')
        ->with('articles')
        ->andReturn(50);

    $this->app->instance(SshTunnelService::class, $mockTunnelService);
    $this->app->instance(DatabaseMigrationService::class, $mockMigrationService);

    $this->artisan('db:migrate-mysql-to-pgsql --dry-run')
        ->expectsOutput('🚀 Starting MySQL to PostgreSQL migration...')
        ->expectsOutput('✅ SSH tunnel is active')
        ->expectsOutput('🔍 DRY RUN MODE - No data will be actually migrated')
        ->expectsOutput('📋 Found 2 tables to migrate')
        ->assertExitCode(0);
});

it('activates ssh tunnel if not active', function (): void {
    // Mock the services
    $mockTunnelService = $this->mock(SshTunnelService::class);
    $mockTunnelService->shouldReceive('isActive')->andReturn(false, true);
    $mockTunnelService->shouldReceive('activate')->once();

    $mockMigrationService = $this->mock(DatabaseMigrationService::class);
    $mockMigrationService->shouldReceive('getSourceTables')
        ->andReturn(['users']);
    $mockMigrationService->shouldReceive('getTableRecordCount')
        ->with('users')
        ->andReturn(10);

    $this->app->instance(SshTunnelService::class, $mockTunnelService);
    $this->app->instance(DatabaseMigrationService::class, $mockMigrationService);

    $this->artisan('db:migrate-mysql-to-pgsql --dry-run')
        ->expectsOutput('SSH tunnel is not active. Attempting to activate...')
        ->expectsOutput('✅ SSH tunnel is active')
        ->assertExitCode(0);
});

it('fails when ssh tunnel cannot be activated', function (): void {
    // Mock the services
    $mockTunnelService = $this->mock(SshTunnelService::class);
    $mockTunnelService->shouldReceive('isActive')->andReturn(false);
    $mockTunnelService->shouldReceive('activate')->once();

    $this->app->instance(SshTunnelService::class, $mockTunnelService);

    $this->artisan('db:migrate-mysql-to-pgsql --dry-run')
        ->expectsOutput('❌ Failed to activate SSH tunnel. Migration aborted.')
        ->assertExitCode(1);
});

it('can migrate specific tables', function (): void {
    // Mock the services
    $mockTunnelService = $this->mock(SshTunnelService::class);
    $mockTunnelService->shouldReceive('isActive')->andReturn(true);

    $mockMigrationService = $this->mock(DatabaseMigrationService::class);
    $mockMigrationService->shouldReceive('getTableRecordCount')
        ->with('users')
        ->andReturn(100);

    $this->app->instance(SshTunnelService::class, $mockTunnelService);
    $this->app->instance(DatabaseMigrationService::class, $mockMigrationService);

    $this->artisan('db:migrate-mysql-to-pgsql --tables=users --dry-run')
        ->expectsOutput('📋 Found 1 tables to migrate')
        ->assertExitCode(0);
});
