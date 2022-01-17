<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class BestReply extends PointType
{
    public int $points = 10;

    protected string $payee = 'author';

    public function __construct($subject)
    {
        $this->subject = $subject;
    }
}
