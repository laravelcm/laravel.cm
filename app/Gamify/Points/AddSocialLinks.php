<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\PointType;

final class AddSocialLinks extends PointType
{
    public ?int $points = 15;

    public ?string $payee = 'user';

    public function __construct(Model $subject)
    {
        $this->subject = $subject;
    }
}
