<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use Laravelcm\Gamify\PointType;

final class FakePayeeFieldPoint extends PointType
{
    protected int $points = 10;

    /** @var string payee model relation with subject */
    protected string $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
