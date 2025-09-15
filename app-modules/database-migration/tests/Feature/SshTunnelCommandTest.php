<?php

declare(strict_types=1);

use Laravelcm\DatabaseMigration\Services\SshTunnelService;

it('has ssh tunnel activate command', function (): void {
    $this->artisan('ssh-tunnel:activate --help')
        ->assertExitCode(0);
});

it('can check ssh tunnel status', function (): void {
    // Mock the service using a spy to avoid final class issues
    $mockService = $this->spy(SshTunnelService::class);
    $mockService->shouldReceive('isActive')->andReturn(false);

    $this->app->instance(SshTunnelService::class, $mockService);

    $this->artisan('ssh-tunnel:activate --check')
        ->expectsOutput('🔍 Checking SSH tunnel status...')
        ->expectsOutput('❌ SSH tunnel is not active')
        ->assertExitCode(1);
});

it('can destroy ssh tunnel', function (): void {
    // Mock the service using a spy to avoid final class issues
    $mockService = $this->spy(SshTunnelService::class);
    $mockService->shouldReceive('destroy')->andReturn(true);

    $this->app->instance(SshTunnelService::class, $mockService);

    $this->artisan('ssh-tunnel:activate --destroy')
        ->expectsOutput('🔥 Destroying SSH tunnel...')
        ->expectsOutput('✅ SSH tunnel destroyed successfully')
        ->assertExitCode(0);
});
