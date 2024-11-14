<?php

namespace App\Exceptions;

use Exception;

/**
 * @property string $message
 */
class UserAlreadyBannedException extends Exception
{
    // @phpstan-ignore-next-line
    protected $message = "Impossible de bannir cet utilisateur car il est déjà banni.";
}