<?php

namespace App\Exceptions;

use Exception;

class CannotBanAdminException extends Exception
{
    protected $message = "Impossible de bannir un administrateur.";
}