<?php

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

class AddSocialLinks extends PointType
{
    public int $points = 15;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->user;
    }
}
