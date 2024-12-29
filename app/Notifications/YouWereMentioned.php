<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class YouWereMentioned extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Reply $reply) {}

    public function via(mixed $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(): MailMessage
    {
        /** @var Thread $thread */
        $thread = $this->reply->replyAble;

        return (new MailMessage)
            ->subject(__('Nouvelle mention: :subject', ['subject' => $thread->subject()]))
            ->line(__(':name vous a mentionné dans le sujet :subject', ['name' => $this->reply->user?->name, 'subject' => $thread->subject()]))
            ->action(__('Afficher'), url($thread->getPathUrl()."#reply-{$this->reply->id}"))
            ->line(__('Merci d\'utiliser Laravel DRC!'));
    }

    public function toArray(): array
    {
        return [
            'type' => 'new_mention',
            'author_name' => $this->reply->user?->name,
            'author_username' => $this->reply->user?->username,
            'author_photo' => $this->reply->user?->profile_photo_url,
            'replyable_id' => $this->reply->replyable_id,
            'replyable_type' => $this->reply->replyable_type,
            // @phpstan-ignore-next-line
            'replyable_subject' => $this->reply->replyAble->replyAbleSubject(),
        ];
    }
}
