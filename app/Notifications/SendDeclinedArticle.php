<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class SendDeclinedArticle extends Notification
{
    use Queueable;

    public function __construct(public Article $article, public array $data)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Article Décliné ❌.'))
            ->greeting(__('Article Décliné : '.$this->data['raison']))
            ->line(__('Nous avons le regret de vous informer que votre article a été décliné.'))
            ->line($this->data['description'])
            ->action(__('Voir mon article'), route('articles.show', $this->article))
            ->line(__('Merci d\'avoir utilisé Laravel Cameroun.!'));
    }
}
