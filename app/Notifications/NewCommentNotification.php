<?php

namespace App\Notifications;

use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Subscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reply $reply, public Subscribe $subscription, public Discussion $discussion)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("Re: {$this->discussion->subject()}")
                    ->line('@' . $this->reply->author->username . ' a répondu à ce sujet.')
                    ->line($this->reply->excerpt(150))
                    ->action('Voir la discussion', route('discussions.show', $this->discussion))
                    ->line('Vous recevez ceci parce que vous êtes abonné à cette discussion.');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_comment',
            'reply' => $this->reply->id,
            'replyable_id' => $this->reply->replyable_id,
            'replyable_type' => $this->reply->replyable_type,
            'replyable_subject' => $this->discussion->subject(),
        ];
    }
}
