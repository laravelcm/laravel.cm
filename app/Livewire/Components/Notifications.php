<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Policies\NotificationPolicy;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Notifications extends Component
{
    use AuthorizesRequests;

    #[Computed]
    public function hasNotifications(): bool
    {
        return Auth::user()?->unreadNotifications()->count() > 0;
    }

    #[Computed]
    public function unreadNotificationsCount(): int
    {
        return Auth::user()?->unreadNotifications()->count() ?? 0;
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = DatabaseNotification::query()
            ->with('notifiable')
            ->findOrFail($notificationId);

        $this->authorize(NotificationPolicy::MARK_AS_READ, $notification);

        $notification->markAsRead();

        Flux::toast(
            text: __('notifications.database.mark_as_read'),
            variant: 'success',
        );

        $this->dispatch('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count()); // @phpstan-ignore-line
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead(); // @phpstan-ignore-line

        Flux::toast(
            text: __('notifications.database.mark_all_as_read'),
            variant: 'success',
        );

        $this->dispatch('NotificationMarkedAsRead', 0);
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
                    fn ($notification): string => Date::parse($notification->created_at)->format('M, Y')
                ),
        ]);
    }
}
