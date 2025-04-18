<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use Laravelcm\Gamify\PointType;

final class AddPhone extends PointType
{
    public int $points = 10;

    protected string $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
