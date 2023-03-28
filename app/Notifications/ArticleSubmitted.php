<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ArticleSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Article $article)
    {
    }

    public function via($notifiable)
    {
        if (
            ! empty(config('services.telegram-bot-api.token')) &&
            ! empty(config('services.telegram-bot-api.channel'))
        ) {
            return [TelegramChannel::class];
        }

        return [];
    }

    public function toTelegram($notifiable)
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
        $content .= 'Par: [@'.$this->article->author->username.']('.route('profile', $this->article->author->username).')';

        return $content;
    }
}
