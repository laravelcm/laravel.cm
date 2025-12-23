<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Laravelcm\Gamify\PointType;

final class FakeWelcomeUserWithNamePoint extends PointType
{
    public $points = 30;

    public $name = 'FakeName';

    public function __construct(mixed $subject, public ?User $author = null) {}

    public function payee(): ?User
    {
        return $this->author;
    }
}
