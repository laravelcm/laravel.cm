<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\PointType;

final class FakePointTypeWithoutSubject extends PointType
{
    public int $point = 12;

    public function __construct(?Model $subject = null)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        return new User;
    }
}
