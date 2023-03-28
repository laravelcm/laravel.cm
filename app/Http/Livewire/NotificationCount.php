<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCount extends Component
{
    public int $count = 0;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'updateCount',
    ];

    public function updateCount(int $count): int
    {
        return $count;
    }

    public function render()
    {
        $this->count = Auth::user()->unreadNotifications()->count();

        return view('livewire.notification-count', [
            'count' => $this->count,
        ]);
    }
}
