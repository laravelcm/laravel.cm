<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Thread;
use Laravelcm\Gamify\PointType;

final class ThreadCreated extends PointType
{
    public int $points = 55;

    protected string $payee = 'user';

    public function __construct(Thread $subject)
    {
        $this->subject = $subject;
    }
}
