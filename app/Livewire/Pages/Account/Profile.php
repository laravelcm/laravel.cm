<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use App\Models\User;
use ArchTech\SEO\SEOManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Profile extends Component
{
    public User $user;

    public function mount(): void
    {
        /** @var SEOManager $seoManager */
        $seoManager = seo();

        $seoManager->meta('robots', 'noindex, nofollow');
    }

    #[Computed(persist: true)]
    public function articles(): Collection
    {
        return Cache::remember(
            key: 'user.'.$this->user->id.'.articles',
            ttl: now()->addDays(3),
            callback: fn () => Article::with('media', 'tags')
                ->select('id', 'title', 'slug', 'body', 'published_at')
                ->published()
                ->whereBelongsTo($this->user)
                ->recent()
                ->limit(5)
                ->get()
        );
    }

    #[Computed(persist: true)]
    public function threads(): Collection
    {
        return Cache::remember(
            key: 'user.'.$this->user->id.'.threads',
            ttl: now()->addDays(3),
            callback: fn () => Thread::with('channels')
                ->withCount('replies')
                ->whereBelongsTo($this->user)->latest()
                ->limit(5)
                ->get()
        );
    }

    #[Computed(persist: true)]
    public function discussions(): Collection
    {
        return Cache::remember(
            key: 'user.'.$this->user->id.'.discussions',
            ttl: now()->addDays(3),
            callback: fn () => Discussion::with('tags')
                ->withCount('replies', 'reactions')
                ->whereBelongsTo($this->user)
                ->limit(5)
                ->get()
        );
    }

    public function render(): View
    {
        return view('livewire.pages.account.profile')
            ->title($this->user->username.' ( '.$this->user->name.')');
    }
}
