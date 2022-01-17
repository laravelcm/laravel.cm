<?php

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

class ReplyCreated extends PointType
{
    public int $points = 2;

    public User $author;

    public function __construct($subject, $author)
    {
        $this->subject = $subject;
        $this->author = $author;
    }

    public function payee()
    {
        return $this->author;
    }
}
