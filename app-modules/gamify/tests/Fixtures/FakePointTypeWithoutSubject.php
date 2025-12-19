<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Laravelcm\Gamify\PointType;

final class FakePointTypeWithoutSubject extends PointType
{
    public $point = 12;

    public function __construct($subject = null)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        return new User;
    }
}
