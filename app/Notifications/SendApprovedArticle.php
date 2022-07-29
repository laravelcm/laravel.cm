<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendApprovedArticle extends Notification implements ShouldQueue
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
                    ->subject('Article Approuvé 🎉.')
                    ->greeting('Article Approuvé 🎉.')
                    ->line('Merci d\'avoir soumis votre article pour créer du contenu au sein de Laravel Cameroun.')
                    ->action('Voir mon article', route('articles.show', $this->article))
                    ->line('Merci d\'avoir utilisé Laravel Cameroun.!');
    }
}
