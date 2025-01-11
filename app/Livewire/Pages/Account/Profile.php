<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Profile extends Component
{
    public User $user;

    #[Computed(persist: true)]
    public function articles(): Collection
    {
        return Article::with('media', 'tags')
            ->select('id', 'title', 'slug', 'body', 'published_at')
            ->whereBelongsTo($this->user)
            ->published()
            ->recent()
            ->limit(5)
            ->get();
    }

    #[Computed(persist: true)]
    public function threads(): Collection
    {
        return Thread::with('channels')
            ->withCount('replies')
            ->whereBelongsTo($this->user)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    #[Computed(persist: true)]
    public function discussions(): Collection
    {
        return Discussion::with('tags')
            ->withCount('replies', 'reactions')
            ->whereBelongsTo($this->user)
            ->limit(5)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.pages.account.profile')
            ->title($this->user->username.' ( '.$this->user->name.')');
    }
}
