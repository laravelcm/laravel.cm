<?php

namespace App\Exceptions;

use Exception;

/**
 * @property string $message
 */
class CannotBanAdminException extends Exception
{
    // @phpstan-ignore-next-line
    protected  $message = "Impossible de bannir un administrateur.";
}