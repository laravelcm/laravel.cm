<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\PointType;

final class AddPhone extends PointType
{
    public ?int $points = 10;

    public ?string $payee = 'user';

    public function __construct(Model $subject)
    {
        $this->subject = $subject;
    }
}
