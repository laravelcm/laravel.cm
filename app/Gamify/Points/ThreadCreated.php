<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Thread;
use Laravelcm\Gamify\PointType;

final class ThreadCreated extends PointType
{
    /** @var int */
    public $points = 55;

    /** @var string */
    public $payee = 'user';

    public function __construct(Thread $subject)
    {
        $this->subject = $subject;
    }
}
