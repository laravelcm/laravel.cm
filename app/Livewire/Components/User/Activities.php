<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection<int, Activity> $activities
 */
final class Activities extends Component
{
    public User $user;

    /**
     * @return Collection<int, Activity>
     */
    #[Computed]
    public function activities(): Collection
    {
        /** @var Collection<int, Activity> $activities */
        $activities = Cache::remember(
            key: 'user.'.$this->user->id.'.activities',
            ttl: now()->addDays(3),
            callback: fn (): Collection => Activity::latestFeed($this->user, 7)
        );

        return $activities;
    }

    public function render(): View
    {
        return view('livewire.components.user.activities');
    }
}
