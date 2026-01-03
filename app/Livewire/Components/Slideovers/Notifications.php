<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Policies\NotificationPolicy;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;

final class Notifications extends SlideOverComponent
{
    public static function panelMaxWidth(): string
    {
        return 'xl';
    }

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

        Gate::authorize(NotificationPolicy::MARK_AS_READ, $notification);

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
        return view('livewire.components.slideovers.notifications', [
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
