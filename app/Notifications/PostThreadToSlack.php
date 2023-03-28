<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PostThreadToSlack extends Notification
{
    use Queueable;

    public function __construct(public Thread $thread)
    {
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack()
    {
        return (new SlackMessage())
            ->to('#forum')
            ->content('[Nouveau sujet] '.$this->thread->author->name.' a crée un nouveau sujet : '.$this->thread->subject().'. '.url($this->thread->getPathUrl()));
    }
}
