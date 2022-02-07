<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSubmittedArticle extends Notification
{
    use Queueable;

    public function __construct(public Article $article)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle soumission d\'article')
                    ->greeting('Bonjour Admin!')
                    ->line("Un nouvel article a été soumis par {$this->article->author->name}")
                    ->action('Afficher l\'article', route('articles.show', $this->article))
                    ->line('Merci d\'avoir utilisé Laravel Cameroun!');
    }
}
