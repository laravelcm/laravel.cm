<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Discussion;
use Laravelcm\Gamify\PointType;

final class DiscussionCreated extends PointType
{
    /** @var int */
    public $points = 20;

    /** @var string */
    public $payee = 'user';

    public function __construct(Discussion $subject)
    {
        $this->subject = $subject;
    }
}
