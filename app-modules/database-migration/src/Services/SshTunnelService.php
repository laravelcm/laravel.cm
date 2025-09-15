<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Services;

use Illuminate\Support\Facades\Log;
use Laravelcm\DatabaseMigration\Exceptions\SshTunnelException;

class SshTunnelService
{
    private string $ncCommand;

    private string $bashCommand;

    private string $sshCommand;

    /** @var array<int, string> */
    private array $output = [];

    public function __construct()
    {
        $this->buildCommands();
    }

    public function activate(): int
    {
        if ($this->isActive()) {
            $this->log('SSH tunnel is already active');

            return 1;
        }

        $this->createTunnel();

        $maxTries = config('ssh-tunnel.connection.max_tries', 3);
        for ($i = 0; $i < $maxTries; $i++) {
            if ($this->isActive()) {
                $this->log('SSH tunnel activated successfully');

                return 2;
            }

            usleep(config('ssh-tunnel.connection.wait_microseconds', 1000000));
        }

        throw new SshTunnelException(
            sprintf(
                "Could not create SSH tunnel with command:\n\t%s\nCheck your configuration.",
                $this->sshCommand
            )
        );
    }

    public function isActive(): bool
    {
        $verifyProcess = config('ssh-tunnel.verify_process', 'nc');

        return match ($verifyProcess) {
            'bash' => $this->runCommand($this->bashCommand),
            default => $this->runCommand($this->ncCommand),
        };
    }

    public function destroy(): bool
    {
        $sshCommand = preg_replace('/[\s]{2}[\s]*/', ' ', $this->sshCommand);
        $killCommand = sprintf('pkill -f "%s"', $sshCommand);

        $result = $this->runCommand($killCommand);

        if ($result) {
            $this->log('SSH tunnel destroyed successfully');
        }

        return $result;
    }

    private function createTunnel(): void
    {
        $nohupPath = config('ssh-tunnel.executables.nohup');
        $nohupLog = config('ssh-tunnel.logging.nohup_log', '/dev/null');

        $command = sprintf(
            '%s %s >> %s 2>&1 &',
            $nohupPath,
            $this->sshCommand,
            $nohupLog
        );

        $this->runCommand($command);

        // Wait for connection to establish
        usleep(config('ssh-tunnel.connection.wait_microseconds', 1000000));

        $this->log('SSH tunnel creation command executed', ['command' => $command]);
    }

    private function buildCommands(): void
    {
        $config = config('ssh-tunnel');

        // Build netcat verification command
        $this->ncCommand = sprintf(
            '%s -vz %s %d > /dev/null 2>&1',
            $config['executables']['nc'],
            $config['local']['address'],
            $config['local']['port']
        );

        // Build bash verification command
        $this->bashCommand = sprintf(
            'timeout 1 %s -c \'cat < /dev/null > /dev/tcp/%s/%d\' > /dev/null 2>&1',
            $config['executables']['bash'],
            $config['local']['address'],
            $config['local']['port']
        );

        // Build SSH tunnel command
        $this->sshCommand = sprintf(
            '%s %s %s -N -i %s -L %d:%s:%d -p %d %s@%s',
            $config['executables']['ssh'],
            $config['ssh']['options'],
            $config['ssh']['verbosity'],
            $config['ssh']['identity_file'],
            $config['local']['port'],
            $config['remote']['bind_address'],
            $config['remote']['bind_port'],
            $config['ssh']['port'],
            $config['ssh']['user'],
            $config['ssh']['hostname']
        );
    }

    private function runCommand(string $command): bool
    {
        $returnVar = 1;
        exec($command, $this->output, $returnVar);

        return $returnVar === 0;
    }

    private function log(string $message, array $context = []): void
    {
        if (! config('ssh-tunnel.logging.enabled', true)) {
            return;
        }

        $channel = config('ssh-tunnel.logging.channel', 'single');
        Log::channel($channel)->info('[SSH Tunnel] '.$message, $context);
    }
}
