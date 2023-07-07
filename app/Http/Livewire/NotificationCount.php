<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class NotificationCount extends Component
{
    public int $count = 0;

    /**
     * @var string[]
     */
    protected $listeners = [
        'NotificationMarkedAsRead' => 'updateCount',
    ];

    public function updateCount(int $count): int
    {
        return $count;
    }

    public function render(): View
    {
        $this->count = Auth::user()->unreadNotifications()->count(); // @phpstan-ignore-line

        return view('livewire.notification-count', [
            'count' => $this->count,
        ]);
    }
}
