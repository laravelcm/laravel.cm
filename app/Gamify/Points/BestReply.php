<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

final class BestReply extends PointType
{
    public int $points = 20;

    protected string $payee = 'author';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
