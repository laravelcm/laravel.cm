<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class PendingArticlesNotification extends Notification
{
    use Queueable;

    public function __construct(public Collection $pendingArticles) {}

    public function via(mixed $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(): TelegramMessage
    {
        $message = $this->content();

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.chat_id'))
            ->content($message);
    }

    private function content(): string
    {
        $message = "Articles soumis en attente d'approbation: \n";
        foreach ($this->pendingArticles as $article) {
            $url = route('articles.show', $article->slug);
            $message .= "• Titre: [{$article->title}]({$url})\n";
            $message .= '• Par: [@'.$article->user?->username.']('.route('profile', $article->user?->username).")\n";
            $message .= "• Soumis le: {$article->submitted_at->format('D/m/Y')}\n\n";
        }

        return $message;
    }
}
