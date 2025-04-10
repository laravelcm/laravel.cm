<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Exceptions;

use Exception;

final class PointSubjectNotSetException extends Exception
{
    protected string $message = 'Initialize $subject field in constructor.';
}
