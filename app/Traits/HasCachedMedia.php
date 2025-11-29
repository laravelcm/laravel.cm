<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\MediaCacheService;
use DateTimeInterface;

trait HasCachedMedia
{
    public function getCacheKey(string $collection): string
    {
        return sprintf(
            '%s.%d.media.%s',
            strtolower(class_basename($this)),
            $this->getKey(),
            $collection
        );
    }

    public function getCacheTtl(): DateTimeInterface
    {
        return now()->addYear();
    }

    public function flushMediaCache(?string $collection = null): void
    {
        app(MediaCacheService::class)->flushCache($this, $collection);
    }

    public function getMediaCollections(): array
    {
        return ['default'];
    }

    public function getCachedMediaUrl(string $collection, ?string $conversion = null): ?string
    {
        return app(MediaCacheService::class)->getCachedMediaUrl($this, $collection, $conversion);
    }
}
