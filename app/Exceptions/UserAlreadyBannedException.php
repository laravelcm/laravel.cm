<?php

namespace App\Exceptions;

use Exception;

class UserAlreadyBannedException extends Exception
{
    protected $message = "Impossible de bannir cet utilisateur car il est déjà banni.";
}