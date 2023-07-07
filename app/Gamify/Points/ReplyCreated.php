<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

final class ReplyCreated extends PointType
{
    public int $points = 10;

    public ?User $author;

    public function __construct(mixed $subject, ?User $author = null)
    {
        $this->subject = $subject;
        $this->author = $author;
    }

    public function payee(): ?User
    {
        return $this->author;
    }
}
