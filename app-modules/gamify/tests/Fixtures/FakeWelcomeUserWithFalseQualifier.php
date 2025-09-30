<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Laravelcm\Gamify\PointType;

final class FakeWelcomeUserWithFalseQualifier extends PointType
{
    protected int $points = 10;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function qualifier(): bool
    {
        return false;
    }

    public function payee(): ?User
    {
        return $this->getSubject()->user;
    }
}
