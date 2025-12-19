<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CannotCreateUser extends Exception
{
    public static function duplicateEmailAddress(string $emailAddress): self
    {
        return new self(sprintf('Cet adresse e-mail [%s] existe déjà.', $emailAddress));
    }

    public static function duplicateUsername(string $username): self
    {
        return new self(sprintf('Ce pseudo [%s] existe déjà.', $username));
    }
}
