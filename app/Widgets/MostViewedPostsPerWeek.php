<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Models\Article;
use Arrilot\Widgets\AbstractWidget;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Contracts\View\View;

final class MostViewedPostsPerWeek extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array<string>
     */
    protected $config = [];

    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 172800; // 2 days

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = 90;

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
