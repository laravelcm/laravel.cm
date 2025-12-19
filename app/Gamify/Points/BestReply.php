<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Reply;
use Laravelcm\Gamify\PointType;

final class BestReply extends PointType
{
    /** @var int */
    public $points = 20;

    /** @var string */
    public $payee = 'user';

    public function __construct(Reply $subject)
    {
        $this->subject = $subject;
    }
}
