<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class ReplyCreated extends PointType
{
    public int $points = 2;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->author;
    }
}
