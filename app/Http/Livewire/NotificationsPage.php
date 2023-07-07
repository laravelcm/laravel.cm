<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class NotificationsPage extends Component
{
    use AuthorizesRequests;

    public string $notificationId;

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

        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification); // @phpstan-ignore-line

        $this->notification->markAsRead(); // @phpstan-ignore-line

        Notification::make()
            ->title(__('Cette notification a été marquée comme lue.'))
            ->success()
            ->seconds(5)
            ->send();

        $this->emit('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count()); // @phpstan-ignore-line
    }

    public function render(): View
    {
        return view('livewire.notifications-page', [
            // @phpstan-ignore-next-line
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
