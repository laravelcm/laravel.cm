<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Exceptions;

use Exception;

final class SshTunnelException extends Exception
{
    public static function connectionFailed(string $command): self
    {
        return new self(
            sprintf(
                "Could not create SSH tunnel with command:\n\t%s\nCheck your configuration.",
                $command
            )
        );
    }

    public static function configurationMissing(string $key): self
    {
        return new self(
            sprintf('SSH tunnel configuration missing: %s', $key)
        );
    }

    public static function executableNotFound(string $executable): self
    {
        return new self(
            sprintf('Executable not found: %s', $executable)
        );
    }
}
