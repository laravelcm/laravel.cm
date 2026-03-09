<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

final class PostArticleToTelegram extends Notification
{
    use Queueable;

    public function __construct(public Article $article) {}

    public function via(mixed $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(): TelegramFile|TelegramMessage
    {
        $url = route('articles.show', $this->article->slug);
        $imageUrl = $this->article->getFirstMediaUrl('media');

        if (filled($imageUrl)) {
            return TelegramFile::create()
                ->to('@laravelcm')
                ->photo($imageUrl)
                ->content("*{$this->article->title}*\n\n_{$this->article->excerpt(200)}_\n\n{$url}");
        }

        return TelegramMessage::create()
            ->to('@laravelcm')
            ->content($this->article->title.' '.$url);
    }
}
