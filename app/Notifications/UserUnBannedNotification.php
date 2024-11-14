<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Mail\UserUnBannedEMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

final class UserUnBannedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): UserUnBannedEMail
    {
        return (new UserUnBannedEMail($this->user))
            ->to($notifiable->email, $notifiable->name);
    }
}
