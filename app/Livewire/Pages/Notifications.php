<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Policies\NotificationPolicy;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read DatabaseNotification $notification
 */
final class Notifications extends Component
{
    use AuthorizesRequests;

    public string $notificationId;

    public function mount(): void
    {
        abort_if(Auth::guest(), 403);
    }

    #[Computed]
    public function notification(): DatabaseNotification
    {
        return DatabaseNotification::query()->findOrFail($this->notificationId);
    }

    public function markAsRead(string $notificationId): void
    {
        $this->notificationId = $notificationId;

        $this->authorize(NotificationPolicy::MARK_AS_READ, $this->notification);

        $this->notification->markAsRead();

        Notification::make()
            ->title(__('Cette notification a été marquée comme lue.'))
            ->success()
            ->seconds(5)
            ->send();

        $this->dispatch('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count()); // @phpstan-ignore-line
    }

    public function render(): View
    {
        return view('livewire.pages.notifications', [
            // @phpstan-ignore-next-line
            'notifications' => Auth::user()
                ->unreadNotifications()
                ->take(10)
                ->get()
                ->groupBy(
                    fn ($notification): string => Carbon::parse($notification->created_at)->format('M, Y')
                ),
        ]);
    }
}
