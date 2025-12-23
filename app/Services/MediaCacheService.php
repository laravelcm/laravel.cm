<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\HasCachedMediaInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;

final readonly class MediaCacheService
{
    public function getCachedMediaUrl(HasCachedMediaInterface&HasMedia $model, string $collection, ?string $conversion = null): ?string
    {
        $cacheKey = $this->buildCacheKey($model, $collection, $conversion);

        return Cache::remember(
            $cacheKey,
            $model->getCacheTtl(),
            fn (): ?string => $this->resolveMediaUrl($model, $collection, $conversion)
        );
    }

    public function flushCache(HasCachedMediaInterface&HasMedia $model, ?string $collection = null): void
    {
        $collections = filled($collection) ? Arr::wrap($collection) : $model->getMediaCollections();

        foreach ($collections as $collectionName) {
            $this->flushCollectionCache($model, $collectionName);
        }
    }

    private function resolveMediaUrl(HasMedia $model, string $collection, ?string $conversion = null): ?string
    {
        $media = $model->getFirstMedia($collection); // @phpstan-ignore-line

        if (! $media) {
            return null;
        }

        return filled($conversion) ? $media->getUrl($conversion) : $media->getUrl();
    }

    private function buildCacheKey(HasCachedMediaInterface $model, string $collection, ?string $conversion = null): string
    {
        $suffix = filled($conversion) ? '.'.$conversion : '';

        return $model->getCacheKey($collection).$suffix;
    }

    private function flushCollectionCache(HasCachedMediaInterface $model, string $collection): void
    {
        $baseKey = $model->getCacheKey($collection);

        resolve(CacheInvalidationService::class)->invalidateByPattern($baseKey);
    }
}
