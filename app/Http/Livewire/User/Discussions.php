<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Discussions extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.user.discussions', [
            'discussions' => $this->user->discussions()
                ->with('tags')
                ->withCount('replies')
                ->limit(5)
                ->get(),
        ]);
    }
}
