<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Exceptions;

final class InvalidPayeeModelException extends \Exception
{
    public function __construct()
    {
        parent::__construct('payee() method must return a model which will get the points.');
    }
}
