<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Profile extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user->load([
            'activities',
            'articles',
            'articles.tags',
            'discussions',
            'discussions.tags',
            'threads',
        ]);
    }

    public function render(): View
    {
        return view('livewire.pages.account.profile', [
            'articles' => $this->user->articles() // @phpstan-ignore-line
                ->recent()
                ->published()
                ->limit(5)
                ->get(),
            'threads' => $this->user->threads()
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
            'discussions' => $this->user->discussions()
                ->limit(5)
                ->get(),
        ])
            ->title($this->user->username.' ( '.$this->user->name.')');
    }
}
