<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use Laravelcm\Gamify\PointType;

final class FakePointWithoutPoint extends PointType
{
    public $payee = 'user';

    public function __construct($subject = null)
    {
        $this->subject = $subject;
    }
}
