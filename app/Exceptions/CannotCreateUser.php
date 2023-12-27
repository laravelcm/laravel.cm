<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CannotCreateUser extends Exception
{
    public static function duplicateEmailAddress(string $emailAddress): self
    {
        return new CannotCreateUser("Cet adresse e-mail [{$emailAddress}] existe déjà.");
    }

    public static function duplicateUsername(string $username): self
    {
        return new CannotCreateUser("Ce pseudo [{$username}] existe déjà.");
    }
}
