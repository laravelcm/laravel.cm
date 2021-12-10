<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIndicator extends Component
{
    public bool $hasNotification = false;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'setHasNotification',
    ];

    public function setHasNotification(int $count): bool
    {
        return $count > 0;
    }

    public function render()
    {
        $this->hasNotification = $this->setHasNotification(
            Auth::user()->unreadNotifications()->count(),
        );

        return view('livewire.notification-indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }
}
