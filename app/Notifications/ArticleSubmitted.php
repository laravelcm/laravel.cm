<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class ArticleSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Article $article)
    {
    }

    public function via(mixed $notifiable): array
    {
        if (
            ! empty(config('services.telegram-bot-api.token')) &&
            ! empty(config('services.telegram-bot-api.channel'))
        ) {
            return [TelegramChannel::class];
        }

        return [];
    }

    public function toTelegram(): TelegramMessage
    {
        $url = route('articles.show', $this->article->slug());

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content($this->content())
            ->button('Voir l\'article', $url);
    }

    private function content(): string
    {
        $content = "*Nouvel Article Soumis!*\n\n";
        $content .= 'Titre: '.$this->article->title."\n";
        $content .= 'Par: [@'.$this->article->user?->username.']('.route('profile', $this->article->user?->username).')';

        return $content;
    }
}
