<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Thread;
use QCod\Gamify\PointType;

final class ThreadDeleted extends PointType
{
    public int $points = 55;

    protected string $payee = 'user';

    public function __construct(Thread $subject)
    {
        $this->subject = $subject;
    }
}
