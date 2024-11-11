<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Models\Article;
use Illuminate\Contracts\View\View;

final class MostLikedPostsPerWeek
{
    /**
     * The configuration array.
     *
     * @var array<string>
     */
    protected array $config = [];

    /**
     * The number of seconds before each reload.
     */
    public int|float $reloadTimeout = 172800; // 2 days

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     */
    public int|float|bool $cacheTime = 0;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(): View
    {
        $articles = Article::published()
            ->popular()
            ->limit(5)
            ->get();

        return view('widgets.most_liked_posts_per_week', [
            'config' => $this->config,
            'articles' => $articles,
        ]);
    }
}
