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

    public function __construct(public readonly Thread $thread)
    {
    }

    /**
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage())
            ->to('#forum')
            ->content('[Nouveau sujet] '.$this->thread->user->name.' a crée un nouveau sujet : '.$this->thread->subject().'. '.url($this->thread->getPathUrl()));
    }
}
