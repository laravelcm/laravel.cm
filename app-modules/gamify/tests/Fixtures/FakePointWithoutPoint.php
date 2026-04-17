<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\PointType;

final class FakePointWithoutPoint extends PointType
{
    public ?string $payee = 'user';

    public function __construct(?Model $subject = null)
    {
        $this->subject = $subject;
    }
}
