<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Reply;
use App\Models\User;
use Laravelcm\Gamify\PointType;

final class ReplyCreated extends PointType
{
    public int $points = 10;

    public function __construct(Reply $subject, public ?User $author = null)
    {
        $this->subject = $subject;
    }

    public function payee(): ?User
    {
        return $this->author;
    }
}
