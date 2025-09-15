<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Console\Commands;

use Illuminate\Console\Command;
use Laravelcm\DatabaseMigration\Exceptions\SshTunnelException;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

final class SshTunnelCommand extends Command
{
    protected $signature = 'ssh-tunnel:activate
                            {--check : Check if tunnel is active without creating it}
                            {--destroy : Destroy existing tunnel}';

    protected $description = 'Create and maintain SSH tunnel for database connections';

    public function handle(SshTunnelService $tunnelService): int
    {
        try {
            if ($this->option('destroy')) {
                return $this->destroyTunnel($tunnelService);
            }

            if ($this->option('check')) {
                return $this->checkTunnel($tunnelService);
            }

            return $this->activateTunnel($tunnelService);

        } catch (SshTunnelException $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    private function activateTunnel(SshTunnelService $tunnelService): int
    {
        $this->info('🔍 Activating SSH tunnel...');

        $result = $tunnelService->activate();

        return match ($result) {
            1 => $this->handleAlreadyActive(),
            2 => $this->handleSuccessfulActivation(),
            default => $this->handleUnexpectedResult(),
        };
    }

    private function checkTunnel(SshTunnelService $tunnelService): int
    {
        $this->info('🔍 Checking SSH tunnel status...');

        if ($tunnelService->isActive()) {
            $this->info('✅ SSH tunnel is active');

            return Command::SUCCESS;
        }

        $this->error('❌ SSH tunnel is not active');

        return Command::FAILURE;
    }

    private function destroyTunnel(SshTunnelService $tunnelService): int
    {
        $this->info('🔥 Destroying SSH tunnel...');

        if ($tunnelService->destroy()) {
            $this->info('✅ SSH tunnel destroyed successfully');

            return Command::SUCCESS;
        }

        $this->error('❌ Failed to destroy SSH tunnel');

        return Command::FAILURE;
    }

    private function handleAlreadyActive(): int
    {
        $this->info('✅ SSH tunnel is already active');

        return Command::SUCCESS;
    }

    private function handleSuccessfulActivation(): int
    {
        $this->info('✅ SSH tunnel activated successfully');

        return Command::SUCCESS;
    }

    private function handleUnexpectedResult(): int
    {
        $this->warn('⚠️  Unexpected result from tunnel activation');

        return Command::FAILURE;
    }
}
