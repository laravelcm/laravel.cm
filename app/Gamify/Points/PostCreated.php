<?php

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

class PostCreated extends PointType
{
    public int $points = 50;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->author;
    }
}
