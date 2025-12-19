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

    private ?string $tempKeyFile = null;

    /** @var array<int, string> */
    private array $output = [];

    public function __construct()
    {
        $this->buildCommands();
    }

    public function __destruct()
    {
        // Ne pas nettoyer automatiquement à la destruction pour permettre
        // la réutilisation du fichier pendant la durée de vie de l'application
        // Le nettoyage doit être fait explicitement via forceCleanupTempKeyFile()
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

            \Illuminate\Support\Sleep::usleep(config('ssh-tunnel.connection.wait_microseconds', 1000000));
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

        $this->cleanupTempKeyFile();

        return $result;
    }

    public function forceCleanupTempKeyFile(): void
    {
        $this->cleanupTempKeyFile();
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

        \Illuminate\Support\Sleep::usleep(config('ssh-tunnel.connection.wait_microseconds', 1000000));

        $this->log('SSH tunnel creation command executed', ['command' => $command]);
    }

    private function buildCommands(): void
    {
        $config = config('ssh-tunnel');

        $this->ncCommand = sprintf(
            '%s -vz %s %d > /dev/null 2>&1',
            $config['executables']['nc'],
            $config['local']['address'],
            $config['local']['port']
        );

        $this->bashCommand = sprintf(
            "timeout 1 %s -c 'cat < /dev/null > /dev/tcp/%s/%d' > /dev/null 2>&1",
            $config['executables']['bash'],
            $config['local']['address'],
            $config['local']['port']
        );

        $identityOption = $this->buildIdentityOption($config);

        $this->sshCommand = sprintf(
            '%s %s %s -N %s -L %d:%s:%d -p %d %s@%s',
            $config['executables']['ssh'],
            $config['ssh']['options'],
            $config['ssh']['verbosity'],
            $identityOption,
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

    private function buildIdentityOption(array $config): string
    {
        if (filled($config['ssh']['private_key_content'])) {
            $tempKeyFile = $this->createTempKeyFile($config['ssh']['private_key_content']);

            return sprintf('-i %s', $tempKeyFile);
        }

        return sprintf('-i %s', $config['ssh']['identity_file']);
    }

    private function createTempKeyFile(string $keyContent): string
    {
        $cleanedKeyContent = $this->normalizeKeyContent($keyContent);

        $keyHash = hash('sha256', $cleanedKeyContent);
        $tempFile = sys_get_temp_dir().'/ssh_key_'.mb_substr($keyHash, 0, 16);

        if (file_exists($tempFile)) {
            $existingContent = file_get_contents($tempFile);
            if ($existingContent === $cleanedKeyContent) {
                $this->tempKeyFile = $tempFile;
                $this->log('Reusing existing SSH key file', ['file' => $tempFile]);

                return $tempFile;
            }
        }

        throw_if(file_put_contents($tempFile, $cleanedKeyContent) === false, SshTunnelException::class, 'Unable to write SSH key to temporary file');

        if (chmod($tempFile, 0600) === false) {
            unlink($tempFile);

            throw new SshTunnelException('Unable to set proper permissions on SSH key file');
        }

        $this->tempKeyFile = $tempFile;

        $this->log('Temporary SSH key file created', ['file' => $tempFile]);

        return $tempFile;
    }

    private function normalizeKeyContent(string $keyContent): string
    {
        if ($this->isBase64Encoded($keyContent)) {
            $decoded = base64_decode($keyContent, true);
            if ($decoded !== false) {
                $keyContent = $decoded;
            }
        }

        $normalized = str_replace('\\n', "\n", $keyContent);
        $normalized = mb_trim($normalized);

        if (! str_ends_with($normalized, "\n")) {
            $normalized .= "\n";
        }

        return $normalized;
    }

    private function isBase64Encoded(string $data): bool
    {
        if (in_array(preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $data), [0, false], true)) {
            return false;
        }

        if (str_contains($data, '-----BEGIN') || str_contains($data, '-----END')) {
            return false;
        }

        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            return false;
        }

        return str_contains($decoded, '-----BEGIN') && str_contains($decoded, '-----END');
    }

    private function cleanupTempKeyFile(): void
    {
        if ($this->tempKeyFile !== null && file_exists($this->tempKeyFile)) {
            if (unlink($this->tempKeyFile)) {
                $this->log('Temporary SSH key file cleaned up', ['file' => $this->tempKeyFile]);
            } else {
                $this->log('Failed to cleanup temporary SSH key file', ['file' => $this->tempKeyFile]);
            }

            $this->tempKeyFile = null;
        }
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
