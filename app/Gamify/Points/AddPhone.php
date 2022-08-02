<?php

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

class AddPhone extends PointType
{
    public int $points = 10;

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->user;
    }
}
