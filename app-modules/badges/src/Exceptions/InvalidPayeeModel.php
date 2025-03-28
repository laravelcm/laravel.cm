<?php

declare(strict_types=1);

namespace QCod\Gamify\Exceptions;

final class InvalidPayeeModel extends \Exception
{
    protected $message = 'payee() method must return a model which will get the points.';
}
