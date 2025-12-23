<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Article;
use App\Services\CacheInvalidationService;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    public function created(Article $article): void
    {
        $this->invalidateCaches($article);
    }

    public function updated(Article $article): void
    {
        $this->invalidateCaches($article);
    }

    public function deleting(Article $article): void
    {
        $this->invalidateCaches($article);
    }

    private function invalidateCaches(Article $article): void
    {
        $cacheService = resolve(CacheInvalidationService::class);

        Cache::forget('article.'.$article->id);

        $cacheService->invalidateByPattern('articles.blog.');
        $cacheService->invalidateByPattern('article.'.$article->id);
    }
}
