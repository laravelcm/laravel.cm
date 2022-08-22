<?php

namespace App\Widgets;

use App\Models\Article;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Contracts\View\View;

class RecentPostsPerWeek extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
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
