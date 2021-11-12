<?php

namespace App\Http\Livewire\User;

use App\Models\Activity;
use App\Models\User;
use Livewire\Component;

class Activities extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.activities', [
            'activities' => Activity::latestFeed($this->user, 5),
        ]);
    }
}
