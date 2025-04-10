<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Reply;
use Laravelcm\Gamify\PointType;

final class BestReply extends PointType
{
    public int $points = 20;

    protected string $payee = 'user';

    public function __construct(Reply $subject)
    {
        $this->subject = $subject;
    }
}
