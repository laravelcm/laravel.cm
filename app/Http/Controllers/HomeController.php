<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Premium\Plan;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        $plans = Cache::remember('plans', now()->addYear(), function () {
            return Plan::with('features')
                ->developer()
                ->get();
        });

        $latestArticles = Cache::remember('latestArticles', now()->addHour(), function () {
            return Article::with(['tags', 'user', 'user.transactions'])
                ->published()
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->orderByViews()
                ->trending()
                ->limit(4)
                ->get();
        });

        $latestThreads = Cache::remember('latestThreads', now()->addHour(), function () {
            return Thread::with(['user', 'user.transactions'])->whereNull('solution_reply_id')
                ->whereBetween('threads.created_at', [now()->subMonths(3), now()])
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });

        $latestDiscussions = Cache::remember('latestDiscussions', now()->addHour(), function () {
            return Discussion::with(['user', 'user.transactions'])
                ->recent()
                ->orderByViews()
                ->limit(3)
                ->get();
        });

        // @phpstan-ignore-next-line
        seo()
            ->description('Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, On partage, on apprend, on découvre et on construit une grande communauté.')
            ->twitterDescription('Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, On partage, on apprend, on découvre et on construit une grande communauté.')
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
