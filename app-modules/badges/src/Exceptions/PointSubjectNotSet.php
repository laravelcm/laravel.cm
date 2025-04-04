<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Exceptions;

use Exception;

final class PointSubjectNotSet extends Exception
{
    protected $message = 'Initialize $subject field in constructor.';
}
