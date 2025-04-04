<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Exceptions;

use Exception;

final class PointsNotDefined extends Exception
{
    protected $message = 'You must define a $points field or a getPoints() method.';
}
