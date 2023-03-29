<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PostThreadToTelegram extends Notification
{
    use Queueable;

    /**
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(mixed $notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->to('@laravelcm')
            ->content("{$notifiable->subject()} ".route('forum.show', $notifiable));
    }
}
