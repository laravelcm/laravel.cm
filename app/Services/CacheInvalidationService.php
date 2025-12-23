<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

final class CacheInvalidationService
{
    public function invalidateByPattern(string $pattern): void
    {
        $driver = Cache::getDefaultDriver();

        match ($driver) {
            'redis' => $this->invalidateRedisPattern($pattern),
            'database' => $this->invalidateDatabasePattern($pattern),
            default => $this->invalidateFallbackPattern(),
        };
    }

    private function invalidateRedisPattern(string $pattern): void
    {
        try {
            $connection = config('cache.stores.redis.connection', 'cache');
            $keys = Redis::connection($connection)->keys($pattern.'*');

            if (filled($keys)) {
                Redis::connection($connection)->del($keys);
            }
        } catch (Exception $exception) {
            $this->invalidateFallbackPattern();
        }
    }

    private function invalidateDatabasePattern(string $pattern): void
    {
        DB::table(config('cache.stores.database.table', 'cache'))
            ->where('key', 'like', $pattern.'%')
            ->delete();
    }

    private function invalidateFallbackPattern(): void
    {
        Cache::flush();
    }
}
