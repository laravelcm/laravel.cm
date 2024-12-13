<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Activities extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render(): View
    {
        return view('livewire.components.user.activities', [
            'activities' => Activity::latestFeed($this->user),
        ]);
    }
}
