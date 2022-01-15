<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class ThreadCreated extends PointType
{
    public int $points = 15;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->author;
    }
}
