<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Exceptions;

use Exception;

final class PointsNotDefinedException extends Exception
{
    public function __construct()
    {
        parent::__construct('You must define a $points field or a getPoints() method.');
    }
}
