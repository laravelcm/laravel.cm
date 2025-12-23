<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Tests\Fixtures;

use App\Models\User;
use Laravelcm\Gamify\PointType;

final class FakeCreatePostPoint extends PointType
{
    public $points = 10;

    public ?User $author;

    public function __construct(mixed $subject, ?User $author = null)
    {
        $this->subject = $subject;
        $this->author = $author;
    }

    public function payee(): ?User
    {
        return $this->author;
    }
}
