<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use Laravelcm\Gamify\PointType;

final class FakePayeeFieldPoint extends PointType
{
    public $points = 10;

    /** @var string */
    public $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
