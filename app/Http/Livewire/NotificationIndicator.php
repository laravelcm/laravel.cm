<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class NotificationIndicator extends Component
{
    public bool $hasNotification = false;

    /**
     * @var string[]
     */
    protected $listeners = [
        'NotificationMarkedAsRead' => 'setHasNotification',
    ];

    public function setHasNotification(int $count): bool
    {
        return $count > 0;
    }

    public function render(): View
    {
        $this->hasNotification = $this->setHasNotification(
            Auth::user()->unreadNotifications()->count(), // @phpstan-ignore-line
        );

        return view('livewire.notification-indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }
}
