<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class AddPhone extends PointType
{
    public int $points = 5;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}
