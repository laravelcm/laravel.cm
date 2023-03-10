<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class BlogPostsOverview extends Widget
{
    protected static string $view = 'filament.widgets.blog-posts-overview';

    protected int|string|array $columnSpan = 5;

    protected function getViewData(): array
    {
        $latestArticles = Cache::remember('last-posts', now()->addHour(), fn () => Article::latest()->limit(3)->get());

        return [
            'latestArticles' => $latestArticles,
        ];
    }
}
