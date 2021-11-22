<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Threads extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.user.threads', [
            'threads' => $this->user->threads()
                ->with(['solutionReply', 'channels', 'reactions'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
