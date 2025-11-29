<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use Laravelcm\Gamify\PointType;

final class FakePointTypeWithoutPayee extends PointType
{
    protected int $point = 24;

    public function __construct(mixed $subject = null)
    {
        $this->subject = $subject;
    }
}
