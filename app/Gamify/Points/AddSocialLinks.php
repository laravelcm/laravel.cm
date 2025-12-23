<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use Laravelcm\Gamify\PointType;

final class AddSocialLinks extends PointType
{
    /** @var int */
    public $points = 15;

    /** @var string */
    public $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
