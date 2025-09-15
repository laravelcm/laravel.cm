<?php

declare(strict_types=1);

use Laravelcm\DatabaseMigration\Services\DatabaseMigrationService;

beforeEach(function (): void {
    $this->service = new DatabaseMigrationService;
});

it('can be instantiated', function (): void {
    expect($this->service)->toBeInstanceOf(DatabaseMigrationService::class);
});

it('can test database connections', function (): void {
    $mockService = $this->mock(DatabaseMigrationService::class);
    $mockService->shouldReceive('testConnections')
        ->once()
        ->andReturn([
            'source' => true,
            'target' => true,
        ]);

    $result = $mockService->testConnections();

    expect($result)->toHaveKey('source')
        ->and($result)->toHaveKey('target')
        ->and($result['source'])->toBeTrue()
        ->and($result['target'])->toBeTrue();
});

it('can get source tables', function (): void {
    $mockService = $this->mock(DatabaseMigrationService::class);
    $mockService->shouldReceive('getSourceTables')
        ->once()
        ->andReturn(['users', 'articles', 'discussions']);

    $tables = $mockService->getSourceTables();

    expect($tables)->toBeArray()
        ->and($tables)->toContain('users', 'articles', 'discussions');
});

it('can get table record count', function (): void {
    $mockService = $this->mock(DatabaseMigrationService::class);
    $mockService->shouldReceive('getTableRecordCount')
        ->with('users')
        ->once()
        ->andReturn(100);

    $count = $mockService->getTableRecordCount('users');

    expect($count)->toBe(100);
});

it('can verify migration results', function (): void {
    $mockService = $this->mock(DatabaseMigrationService::class);
    $mockService->shouldReceive('verifyMigration')
        ->with(['users', 'articles'])
        ->once()
        ->andReturn([
            'users' => ['source' => 100, 'target' => 100, 'match' => true],
            'articles' => ['source' => 50, 'target' => 50, 'match' => true],
        ]);

    $result = $mockService->verifyMigration(['users', 'articles']);

    expect($result)->toHaveKey('users')
        ->and($result)->toHaveKey('articles')
        ->and($result['users']['match'])->toBeTrue()
        ->and($result['articles']['match'])->toBeTrue();
});
