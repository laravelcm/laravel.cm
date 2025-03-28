<?php

declare(strict_types=1);

namespace QCod\Gamify\Exceptions;

use Exception;

final class PointSubjectNotSet extends Exception
{
    protected $message = 'Initialize $subject field in constructor.';
}
