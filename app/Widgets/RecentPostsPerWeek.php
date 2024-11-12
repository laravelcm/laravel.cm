<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Models\Article;
use Illuminate\Contracts\View\View;

final class RecentPostsPerWeek
{
    /**
     * @var array<string>
     */
    protected array $config = [];

    public function run(): View
    {
        $articles = Article::recent()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->limit(5)
            ->get();

        return view('widgets.recent_posts_per_week', [
            'config' => $this->config,
            'articles' => $articles,
        ]);
    }
}
