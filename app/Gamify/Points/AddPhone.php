<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\User;
use QCod\Gamify\PointType;

final class AddPhone extends PointType
{
    public int $points = 10;

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        // @phpstan-ignore-next-line
        return $this->getSubject()->user;
    }
}
