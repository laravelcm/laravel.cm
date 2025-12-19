<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Laravelcm\Gamify\PointType;

final class FakePointTypeWithoutPayee extends PointType
{
    public $points = 24;

    public function __construct(mixed $subject = null)
    {
        $this->subject = $subject ?? User::factory()->create();
    }

    public function payee(): null
    {
        return null;
    }
}
