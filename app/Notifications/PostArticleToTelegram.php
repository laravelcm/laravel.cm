<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PostArticleToTelegram extends Notification
{
    use Queueable;

    public function __construct(public Article $article)
    {
    }

    /**
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(): TelegramMessage
    {
        return TelegramMessage::create()
            ->to('@laravelcm')
            ->content("{$this->article->title} ".route('articles.show', $this->article->slug()));
    }
}
