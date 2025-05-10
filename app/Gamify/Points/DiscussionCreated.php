<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Discussion;
use Laravelcm\Gamify\PointType;

final class DiscussionCreated extends PointType
{
    public int $points = 20;

    protected string $payee = 'user';

    public function __construct(Discussion $subject)
    {
        $this->subject = $subject;
    }
}
