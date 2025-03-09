<?php

declare(strict_types=1);

namespace App\Notifications;

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
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails/article.article_declined.subject'))
            ->markdown('emails.article_declined', ['article' => $this->article]);
    }
}
