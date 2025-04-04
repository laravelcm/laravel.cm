<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Exceptions;

use Exception;

final class PointSubjectNotSetException extends Exception
{
    public function __construct()
    {
        parent::__construct('Initialize $subject field in constructor.');
    }
}
