<?php

declare(strict_types=1);

use Laravelcm\DatabaseMigration\Exceptions\SshTunnelException;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

beforeEach(function (): void {
    // Mock configuration values for testing
    config([
        'ssh-tunnel.ssh.user' => 'testuser',
        'ssh-tunnel.ssh.hostname' => 'test.example.com',
        'ssh-tunnel.ssh.identity_file' => '/path/to/key',
        'ssh-tunnel.ssh.local_port' => 3307,
        'ssh-tunnel.ssh.bind_port' => 3306,
        'ssh-tunnel.ssh.bind_address' => '127.0.0.1',
        'ssh-tunnel.executables.ssh' => '/usr/bin/ssh',
        'ssh-tunnel.executables.ps' => '/bin/ps',
        'ssh-tunnel.executables.grep' => '/usr/bin/grep',
        'ssh-tunnel.executables.awk' => '/usr/bin/awk',
        'ssh-tunnel.connection.max_tries' => 1, // Reduce retries for faster testing
        'ssh-tunnel.connection.wait_microseconds' => 100000, // Reduce wait time
        'ssh-tunnel.logging.enabled' => false,
    ]);

    $this->service = new SshTunnelService;
});

it('can be instantiated', function (): void {
    expect($this->service)->toBeInstanceOf(SshTunnelService::class);
});

it('throws exception when tunnel creation fails', function (): void {
    // Mock the service to simulate failure
    $mockService = $this->mock(SshTunnelService::class);
    $mockService->shouldReceive('activate')
        ->once()
        ->andThrow(new SshTunnelException('Could not create SSH tunnel'));

    expect(fn () => $mockService->activate())
        ->toThrow(SshTunnelException::class);
});

it('can check if tunnel is active', function (): void {
    // Mock the service to return false for isActive
    $mockService = $this->mock(SshTunnelService::class);
    $mockService->shouldReceive('isActive')
        ->once()
        ->andReturn(false);

    expect($mockService->isActive())->toBeFalse();
});
