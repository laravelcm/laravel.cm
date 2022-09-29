<?php

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    use AuthorizesRequests;

    public $notificationId;

    public function mount(): void
    {
        abort_if(Auth::guest(), 403);
    }

    public function getNotificationProperty(): DatabaseNotification
    {
        return DatabaseNotification::findOrFail($this->notificationId);
    }

    public function markAsRead(string $notificationId): void
    {
        $this->notificationId = $notificationId;

        // @phpstan-ignore-next-line
        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification);

        // @phpstan-ignore-next-line
        $this->notification->markAsRead();

        // @ToDo mettre un nouveau system de notification
        // $this->notification()->success('Notification', 'Cette notification a été marquée comme lue.');

        $this->emit('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count());
    }

    public function render(): View
    {
        return view('livewire.notifications', [
            'notifications' => Auth::user()
                ->unreadNotifications()
                ->take(10)
                ->get()
                ->groupBy(
                    fn ($notification) => Carbon::parse($notification->created_at)->format('M, Y')
                ),
        ]);
    }
}
