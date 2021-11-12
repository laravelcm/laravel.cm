<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification
{
    public function __construct(public Reply $reply)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
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
                    ->subject("Nouvelle mention: {$this->reply->replyAble->subject()}")
                    ->line($this->reply->author->name . ' vous a mentionné dans le sujet ' . $this->reply->replyAble->subject())
                    ->action('Afficher', url($this->reply->replyAble->getPathUrl() . "#reply-{$this->reply->id}"))
                    ->line("Merci d'utiliser Laravel Cameroun!");
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_mention',
            'author_name' => $this->reply->author->name,
            'author_username' => $this->reply->author->username,
            'author_photo' => $this->reply->author->profile_photo_url,
            'replyable_type' => $this->reply->replyable_type,
            'replyable_subject' => $this->reply->replyAble->replyAbleSubject(),
        ];
    }
}
