<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Exceptions;

final class InvalidPayeeModelException extends \Exception
{
    protected $message = 'payee() method must return a model which will get the points.';
}
