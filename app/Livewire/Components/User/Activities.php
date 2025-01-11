<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Activities extends Component
{
    public User $user;

    #[Computed(persist: true)]
    public function activities(): Collection
    {
        return Cache::remember(
            key: 'activities.'.$this->user->id,
            ttl: now()->addDays(3),
            callback: fn () => Activity::latestFeed($this->user)
        );
    }

    public function render(): View
    {
        return view('livewire.components.user.activities');
    }
}
