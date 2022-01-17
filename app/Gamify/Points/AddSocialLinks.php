<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class AddSocialLinks extends PointType
{
    public int $points = 6;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}
