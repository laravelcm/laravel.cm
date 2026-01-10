<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use Illuminate\Support\Collection;

final class FeedAggregator
{
    public static function getFeedItems(): Collection
    {
        $articles = Article::getFeedItems();
        $discussions = Discussion::getFeedItems();
        $threads = Thread::getFeedItems();

        return $articles
            ->merge($discussions)
            ->merge($threads)
            ->sortByDesc(function ($item) {
                if ($item instanceof Article) {
                    return $item->published_at ?? $item->updated_at;
                }

                if ($item instanceof Thread) {
                    return $item->latest_creation ?? $item->created_at;
                }

                return $item->updated_at; // @phpstan-ignore-line
            })
            ->values()
            ->take(50);
    }
}
