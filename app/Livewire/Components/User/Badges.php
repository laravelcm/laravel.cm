<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Badges extends Component
{
    public User $user;

    #[Computed]
    public function badges(): Collection
    {
        return Cache::remember(
            key: 'badges.'.$this->user->id,
            ttl: now()->addDays(3),
            callback: fn (): Collection => $this->user->badges
        );
    }

    public function render(): View
    {
        return view('livewire.components.user.badges');
    }
}
