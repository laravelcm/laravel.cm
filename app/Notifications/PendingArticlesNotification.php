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
            ->to(config('services.telegram-bot-api.channel'))
            ->content($message);
    }

    private function content(): string
    {
        $heading = "*Articles soumis en attente d'approbation!*";
        $messages = "{$heading}\n\n";

        foreach ($this->pendingArticles as $article) {
            $messages .= __(
                "[@:username](:profile_url) a soumit l'article [:title](:url) le: :date\n\n",
                [
                    'username' => $article->user?->username,
                    'profile_url' => route('profile', $article->user?->username),
                    'title' => $article->title,
                    'url' => route('articles.show', $article->slug),
                    'date' => $article->submitted_at->translatedFormat('d M Y'),
                ]
            );
        }

        return $messages;
    }
}
