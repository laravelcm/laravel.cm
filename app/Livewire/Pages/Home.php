<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Plan;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class Home extends Component
{
    public function render(): View
    {
        $ttl = now()->addDays(2);

        // @phpstan-ignore-next-line
        seo()
            ->description(__('pages/home.description'))
            ->twitterDescription(__('pages/home.description'))
            ->image(asset('/images/socialcard.png'))
            ->twitterSite('laravelcd')
            ->withUrl();

        return view('livewire.pages.home', [
            'plans' => Cache::remember(
                key: 'plans',
                ttl: now()->addYear(),
                callback: fn () => Plan::query()->developer()->get()
            ),
            'latestArticles' => Cache::remember(
                key: 'latestArticles',
                ttl: $ttl,
                callback: fn (): Collection => Article::with(['tags', 'user', 'user.transactions']) // @phpstan-ignore-line
                    ->published()
                    ->orderByDesc('sponsored_at')
                    ->orderByDesc('published_at')
                    ->orderByViews()
                    ->trending()
                    ->limit(4)
                    ->get()
            ),
            'latestThreads' => Cache::remember(
                key: 'latestThreads',
                ttl: $ttl,
                callback: fn (): Collection => Thread::with(['user', 'user.transactions'])
                    ->whereNull('solution_reply_id')
                    ->whereBetween('threads.created_at', [now()->subMonths(3), now()])
                    ->inRandomOrder()
                    ->limit(4)
                    ->get()
            ),
            'latestDiscussions' => Cache::remember(
                key: 'latestDiscussions',
                ttl: $ttl,
                callback: fn (): Collection => Discussion::with(['user', 'user.transactions']) // @phpstan-ignore-line
                    ->recent()
                    ->orderByViews()
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
