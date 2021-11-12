<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Threads extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.threads', [
            'threads' => Cache::remember(
                'user-threads',
                60 * 60,
                fn () => $this->user->threads()->with(['solutionReply', 'channels', 'reactions'])->orderByDesc('created_at')->limit(5)->get()
            ),
        ]);
    }
}
