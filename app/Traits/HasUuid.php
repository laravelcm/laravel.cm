<?php

declare(strict_types=1);

namespace App\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait HasUuid
{
    public function uuid(): UuidInterface
    {
        return Uuid::fromString($this->uuid);
    }

    public function getKeyName(): string
    {
        return 'uuid';
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public static function findByUuidOrFail(UuidInterface $uuid): self
    {
        return static::where('uuid', $uuid->toString())->firstOrFail();
    }
}
