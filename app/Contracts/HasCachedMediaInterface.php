<?php

declare(strict_types=1);

namespace App\Contracts;

use DateTimeInterface;

interface HasCachedMediaInterface
{
    public function getCacheKey(string $collection): string;

    public function getCacheTtl(): DateTimeInterface;

    public function flushMediaCache(?string $collection = null): void;

    public function getMediaCollections(): array;
}
