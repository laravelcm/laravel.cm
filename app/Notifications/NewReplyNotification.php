<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Mail\NewReplyEmail;
use App\Models\Reply;
use App\Models\Subscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reply $reply, public Subscribe $subscription)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): NewReplyEmail
    {
        return (new NewReplyEmail($this->reply, $this->subscription))
            ->to($notifiable->email, $notifiable->name);
    }

    /**
     * @param  mixed  $notifiable
     * @return array<string, string|int>
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_reply',
            'reply' => $this->reply->id,
            'replyable_id' => $this->reply->replyable_id,
            'replyable_type' => $this->reply->replyable_type,
            // @phpstan-ignore-next-line
            'replyable_subject' => $this->reply->replyAble->replyAbleSubject(),
        ];
    }
}
