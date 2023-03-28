<?php

declare(strict_types=1);

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
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 60 * 60 * 24 * 2; // 2 days

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = 90;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(): View
    {
        $articles = Article::withViewsCount(Period::create(now()->startOfWeek(), now()->endOfWeek()))
            ->published()
            ->orderByDesc('views_count')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return view('widgets.most_viewed_posts_per_week', [
            'config' => $this->config,
            'articles' => $articles,
        ]);
    }
}
