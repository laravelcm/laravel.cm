<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

final class PostThreadToSlack extends Notification
{
    use Queueable;

    public readonly Thread $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread->load('user');
    }

    public function via(mixed $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage())
            ->to('#forum')
            ->content('[Nouveau sujet] '.$this->thread->user?->name.' a crée un nouveau sujet : '.$this->thread->subject().'. '.url($this->thread->getPathUrl()));
    }
}
