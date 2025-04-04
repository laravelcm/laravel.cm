<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Exceptions;

final class InvalidPayeeModel extends \Exception
{
    protected $message = 'payee() method must return a model which will get the points.';
}
