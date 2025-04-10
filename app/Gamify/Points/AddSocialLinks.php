<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use Laravelcm\Gamify\PointType;

final class AddSocialLinks extends PointType
{
    public int $points = 15;

    protected string $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
