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
            key: 'user.'.$this->user->id.'.activities',
            ttl: now()->addDays(3),
            callback: fn (): Collection => Activity::latestFeed($this->user, 7)
        );
    }

    public function render(): View
    {
        return view('livewire.components.user.activities');
    }
}
