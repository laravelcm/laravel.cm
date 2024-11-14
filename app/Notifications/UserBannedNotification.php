<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Mail\UserBannedEMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

final class UserBannedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): UserBannedEMail
    {
        return (new UserBannedEMail($this->user))
            ->to($notifiable->email, $notifiable->name);
    }
}
