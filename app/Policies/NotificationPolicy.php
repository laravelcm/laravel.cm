<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    public const MARK_AS_READ = 'markAsRead';

    /**
     * Determine if the given notification can be marked as read by the user.
     */
    public function markAsRead(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable->is($user);
    }
}
