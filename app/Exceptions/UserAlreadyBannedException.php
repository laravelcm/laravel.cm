<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * @property string $message
 */
final class UserAlreadyBannedException extends Exception
{
    // @phpstan-ignore-next-line
    protected $message = 'Impossible de bannir cet utilisateur car il est déjà banni.';
}
