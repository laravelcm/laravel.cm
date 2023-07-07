<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Thread;
use App\Models\User;
use QCod\Gamify\PointType;

final class ThreadCreated extends PointType
{
    public int $points = 55;

    public function __construct(Thread $subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->user;
    }
}
