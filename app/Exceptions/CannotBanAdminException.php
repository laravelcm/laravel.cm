<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * @property string $message
 */
final class CannotBanAdminException extends Exception
{
    // @phpstan-ignore-next-line
    protected $message = 'Impossible de bannir un administrateur.';
}
