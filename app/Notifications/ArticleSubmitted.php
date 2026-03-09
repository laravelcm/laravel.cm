<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

final class ArticleSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Article $article) {}

    public function via(mixed $notifiable): array
    {
        if (
            filled(config('services.telegram-bot-api.token')) &&
            filled(config('services.telegram-bot-api.channel'))
        ) {
            return [TelegramChannel::class];
        }

        return [];
    }

    public function toTelegram(): TelegramFile|TelegramMessage
    {
        /** @var string $telegramChannel */
        $telegramChannel = config('services.telegram-bot-api.channel');
        $url = route('articles.show', $this->article->slug);
        $imageUrl = $this->article->getFirstMediaUrl('media');

        if (filled($imageUrl)) {
            return TelegramFile::create()
                ->to($telegramChannel)
                ->photo($imageUrl)
                ->content($this->content())
                ->button("Voir l'article", $url);
        }

        return TelegramMessage::create()
            ->to($telegramChannel)
            ->content($this->content())
            ->button("Voir l'article", $url);
    }

    private function content(): string
    {
        $content = "*Nouvel Article Soumis!*\n\n";
        $content .= '*'.$this->article->title."*\n";
        $content .= '_'.$this->article->excerpt(200)."_\n\n";

        return $content.('Par: [@'.$this->article->user->username.']('.route('profile', $this->article->user->username).')');
    }
}
