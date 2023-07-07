<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Models\Article;
use App\Models\User;
use Arrilot\Widgets\AbstractWidget;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Contracts\View\View;

final class RecentNumbers extends AbstractWidget
{
    protected $config = [];

    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 5400;

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = 90;

    public function run(): View
    {
        $lastMonth = now()->subMonth();
        $countUsers = User::count();
        $lastMonthRegistered = User::query()->whereBetween('created_at', [
            $lastMonth->startOfMonth()->format('Y-m-d'),
            $lastMonth->endOfMonth()->format('Y-m-d'),
        ])->count();
        $currentMonthRegistered = User::query()->where('created_at', '>=', now()->startOfMonth())->count();
        $difference = $currentMonthRegistered - $lastMonthRegistered;

        $countArticles = Article::count();
        $lastMonthArticles = Article::query()->whereBetween('created_at', [
            $lastMonth->startOfMonth()->format('Y-m-d'),
            $lastMonth->endOfMonth()->format('Y-m-d'),
        ])->count();
        $currentMonthArticles = Article::query()->where('created_at', '>=', now()->startOfMonth())->count();
        $differenceArticle = $currentMonthArticles - $lastMonthArticles;

        $totalViews = views(Article::class)->count();
        $lastMonthViews = views(Article::class)
            ->period(Period::create(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()))
            ->remember(now()->addMonth())
            ->count();
        $currentViews = views(Article::class)->period(Period::upto(now()->startOfMonth()))->count();
        $differenceViews = $currentViews - $lastMonthViews;

        return view('widgets.recent_numbers', [
            'config' => $this->config,
            'users' => [
                'count' => $countUsers,
                'increase' => $difference > 0,
                'decreased' => $difference < 0,
                'current' => $currentMonthRegistered,
            ],
            'articles' => [
                'count' => $countArticles,
                'increase' => $differenceArticle > 0,
                'decreased' => $differenceArticle < 0,
                'current' => $currentMonthArticles,
            ],
            'views' => [
                'count' => $totalViews,
                'increase' => $differenceViews > 0,
                'decreased' => $differenceViews < 0,
                'current' => $currentViews,
            ],
        ]);
    }
}
