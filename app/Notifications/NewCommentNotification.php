<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Subscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Reply $reply,
        public readonly Subscribe $subscription,
        public readonly Discussion $discussion
    ) {
    }

    /**
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject("Re: {$this->discussion->subject()}")
            ->line(__('@:name a répondu à ce sujet.', ['name' => $this->reply->user?->username]))
            ->line($this->reply->excerpt(150))
            ->action(__('Voir la discussion'), route('discussions.show', $this->discussion))
            ->line(__('Vous recevez ceci parce que vous êtes abonné à cette discussion.'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
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
