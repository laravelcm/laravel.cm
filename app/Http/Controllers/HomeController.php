<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Plan;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class HomeController
{
    public function __invoke(): View
    {
        $plans = Cache::remember('plans', now()->addYear(), function () {
            return Plan::query()
                ->developer()
                ->get();
        });

        $latestArticles = Cache::remember('latestArticles', now()->addMinute(), fn (): Collection => Article::with(['tags', 'user', 'user.transactions'])
            ->published()
            ->orderByDesc('sponsored_at')
            ->orderByDesc('published_at')
            ->orderByViews()
            ->trending()
            ->limit(4)
            ->get());

        $latestThreads = Cache::remember('latestThreads', now()->addMinute(), fn (): Collection => Thread::with(['user', 'user.transactions'])->whereNull('solution_reply_id')
            ->whereBetween('threads.created_at', [now()->subMonths(3), now()])
            ->inRandomOrder()
            ->limit(4)
            ->get());

        $latestDiscussions = Cache::remember('latestDiscussions', now()->addMinute(), fn (): Collection => Discussion::with(['user', 'user.transactions'])
            ->recent()
            ->orderByViews()
            ->limit(3)
            ->get());

        // @phpstan-ignore-next-line
        seo()
            ->description(__('pages/home.description'))
            ->twitterDescription(__('pages/home.description'))
            ->image(asset('/images/socialcard.png'))
            ->twitterSite('laravelcm')
            ->withUrl();

        return view('home', compact(
            'latestArticles',
            'latestThreads',
            'latestDiscussions',
            'plans'
        ));
    }
}
