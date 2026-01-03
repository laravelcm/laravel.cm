<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

final class NotificationPolicy
{
    use HandlesAuthorization;

    public const string MARK_AS_READ = 'markAsRead';

    public function markAsRead(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable && $notification->notifiable->is($user);
    }
}
