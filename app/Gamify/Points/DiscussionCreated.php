<?php

namespace App\Gamify\Points;

use App\Models\Discussion;
use App\Models\User;
use QCod\Gamify\PointType;

class DiscussionCreated extends PointType
{
    public int $points = 20;

    public function __construct(Discussion $subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->author;
    }
}
