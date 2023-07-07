<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class SendApprovedArticle extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Article $article)
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Article Approuvé 🎉.'))
            ->greeting(__('Article Approuvé 🎉.'))
            ->line(__('Merci d\'avoir soumis votre article pour créer du contenu au sein de Laravel Cameroun.'))
            ->action(__('Voir mon article'), route('articles.show', $this->article))
            ->line(__('Merci d\'avoir utilisé Laravel Cameroun.!'));
    }
}
