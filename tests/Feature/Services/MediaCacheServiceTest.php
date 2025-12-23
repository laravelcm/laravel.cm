<?php

declare(strict_types=1);

use App\Models\User;
use App\Services\MediaCacheService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    $this->service = resolve(MediaCacheService::class);
    $this->user = User::factory()->create();

    Cache::flush();
    Storage::fake('public');

    $this->testFile = UploadedFile::fake()->image('avatar.jpg', 150, 150);
});

describe(MediaCacheService::class, function (): void {
    it('caches media URL when media exists', function (): void {
        $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $url = $this->service->getCachedMediaUrl($this->user, 'avatar');

        expect($url)->not->toBeNull()
            ->and(Cache::has($this->user->getCacheKey('avatar')))->toBeTrue();
    });

    it('returns null when no media exists', function (): void {
        $url = $this->service->getCachedMediaUrl($this->user, 'avatar');

        expect($url)->toBeNull();
    });

    it('uses cached URL on subsequent calls', function (): void {
        $media = $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $firstUrl = $this->service->getCachedMediaUrl($this->user, 'avatar');

        $media->delete();

        $secondUrl = $this->service->getCachedMediaUrl($this->user, 'avatar');

        expect($firstUrl)->toBe($secondUrl);
    });

    it('flushes cache for specific collection', function (): void {
        $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $this->service->getCachedMediaUrl($this->user, 'avatar');
        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeTrue();

        $this->service->flushCache($this->user, 'avatar');
        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeFalse();
    });

    it('flushes all collection caches when no collection specified', function (): void {
        $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $this->service->getCachedMediaUrl($this->user, 'avatar');
        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeTrue();

        $this->service->flushCache($this->user);

        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeFalse();
    });

    it('handles media conversions', function (): void {
        $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $originalUrl = $this->service->getCachedMediaUrl($this->user, 'avatar');

        expect($originalUrl)->not->toBeNull()
            ->and(Cache::has($this->user->getCacheKey('avatar')))->toBeTrue();
    });

    it('respects cache TTL configuration', function (): void {
        $this->user->addMedia($this->testFile)
            ->toMediaCollection('avatar');

        $this->service->getCachedMediaUrl($this->user, 'avatar');

        $cacheKey = $this->user->getCacheKey('avatar');
        expect(Cache::has($cacheKey))->toBeTrue();

        $cachedUrl = Cache::get($cacheKey);
        expect($cachedUrl)->not->toBeNull();
    });
})->group('media', 'Cache');

describe('HasCachedMedia', function (): void {
    it('generates correct cache keys', function (): void {
        $key = $this->user->getCacheKey('avatar');
        expect($key)->toBe(sprintf('user.%s.media.avatar', $this->user->id));
    });

    it('provides correct cache TTL', function (): void {
        $ttl = $this->user->getCacheTtl();
        expect($ttl)->toBeInstanceOf(DateTimeInterface::class)
            ->and($ttl->diff(now())->days)->toBeGreaterThan(360);
    });

    it('flushes media cache correctly', function (): void {
        $testFile = UploadedFile::fake()->image('test.jpg', 150, 150);
        $this->user->addMedia($testFile)
            ->toMediaCollection('avatar');

        $this->service->getCachedMediaUrl($this->user, 'avatar');
        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeTrue();

        $this->user->flushMediaCache('avatar');
        expect(Cache::has($this->user->getCacheKey('avatar')))->toBeFalse();
    });

    it('returns media collections defined by model', function (): void {
        $collections = $this->user->getMediaCollections();
        expect($collections)->toContain('avatar');
    });
})->group('media', 'cache');
