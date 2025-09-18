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

        return view('livewire.pages.home', [
            'plans' => Cache::remember(
                key: 'plans',
                ttl: now()->addYear(),
                callback: fn (): Collection => Plan::query()->developer()->get()
            ),
            'articles' => Cache::tags('articles')->remember(
                key: 'home.articles',
                ttl: $ttl,
                callback: fn (): Collection => Article::with(['tags', 'media', 'user', 'user.transactions', 'user.media']) // @phpstan-ignore-line
                    ->published()
                    ->orderByDesc('sponsored_at')
                    ->orderByDesc('published_at')
                    ->orderByViews()
                    ->trending()
                    ->limit(4)
                    ->get()
            ),
            'threads' => Cache::tags('threads')->remember(
                key: 'home.threads',
                ttl: $ttl,
                callback: fn (): Collection => Thread::with(['user', 'user.transactions', 'user.media'])
                    ->whereNull('solution_reply_id')
                    ->whereBetween('threads.created_at', [now()->subMonths(3), now()])
                    ->inRandomOrder()
                    ->limit(4)
                    ->get()
            ),
            'discussions' => Cache::tags('discussions')->remember(
                key: 'home.discussions',
                ttl: $ttl,
                callback: fn (): Collection => Discussion::with(['user', 'user.transactions', 'user.media']) // @phpstan-ignore-line
                    ->recent()
                    ->orderByViews()
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
