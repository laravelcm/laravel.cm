<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class Home extends Component
{
    public function render(): View
    {
        $ttl = now()->addHours(6);

        return view('livewire.pages.home', [
            'articles' => Cache::tags('articles')->remember(
                key: 'home.articles',
                ttl: $ttl,
                callback: fn (): Collection => Article::with(['tags', 'media']) // @phpstan-ignore-line
                    ->latest('published_at')
                    ->published()
                    ->limit(4)
                    ->get()
            ),
            'threads' => Cache::tags('threads')->remember(
                key: 'home.threads',
                ttl: $ttl,
                callback: fn (): Collection => Thread::with([
                    'user:id,username,name,avatar_type',
                    'user.media',
                    'user.providers:id,user_id,provider,avatar'
                ])
                    ->whereNull('solution_reply_id')
                    ->whereBetween('threads.created_at', [now()->subMonths(3), now()])
                    ->latest()
                    ->limit(4)
                    ->get()
            ),
            'discussions' => Cache::tags('discussions')->remember(
                key: 'home.discussions',
                ttl: $ttl,
                callback: fn (): Collection => Discussion::with([
                    'user:id,username,name,avatar_type',
                    'user.media',
                    'user.providers:id,user_id,provider,avatar'
                ]) // @phpstan-ignore-line
                    ->recent()
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
