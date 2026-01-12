<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\NotificationType;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ArticleDeclinedNotification extends Notification
{
    use Queueable;

    public function __construct(public Article $article) {}

    public function via(mixed $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails/article.article_declined.subject'))
            ->markdown('emails.article_declined', ['article' => $this->article]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => NotificationType::ArticleDeclined->value,
            'article' => $this->article,
            'owner' => $this->article->user->name,
            'email' => $this->article->user->email,
        ];
    }
}
