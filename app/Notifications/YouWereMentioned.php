<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification implements ShouldQueue
{
    use Queueable;

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
    public function toMail($notifiable): MailMessage
    {
        /** @var Thread $thread */
        $thread = $this->reply->replyAble;

        return (new MailMessage())
                    ->subject("Nouvelle mention: {$thread->subject()}")
                    ->line($this->reply->author->name.' vous a mentionné dans le sujet '.$thread->subject())
                    ->action('Afficher', url($thread->getPathUrl()."#reply-{$this->reply->id}"))
                    ->line("Merci d'utiliser Laravel Cameroun!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, string|int>
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_mention',
            'author_name' => $this->reply->author->name,
            'author_username' => $this->reply->author->username,
            'author_photo' => $this->reply->author->profile_photo_url,
            'replyable_id' => $this->reply->replyable_id,
            'replyable_type' => $this->reply->replyable_type,
            // @phpstan-ignore-next-line
            'replyable_subject' => $this->reply->replyAble->replyAbleSubject(),
        ];
    }
}
