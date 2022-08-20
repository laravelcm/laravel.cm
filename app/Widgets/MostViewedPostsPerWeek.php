<?php

namespace App\Widgets;

use App\Models\Article;
use Arrilot\Widgets\AbstractWidget;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Contracts\View\View;

class MostViewedPostsPerWeek extends AbstractWidget
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
        $articles = Article::withViewsCount()
            ->published()
            ->orderByDesc('published_at')
            ->orderByViews('desc', Period::create(now()->startOfWeek(), now()->endOfWeek()))
            ->limit(5)
            ->get();

        return view('widgets.most_viewed_posts_per_week', [
            'config' => $this->config,
            'articles' => $articles,
        ]);
    }
}
