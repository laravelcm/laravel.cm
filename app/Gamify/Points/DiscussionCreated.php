<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class DiscussionCreated extends PointType
{
    public int $points = 10;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->author;
    }
}
