<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Notifications\PostThreadToSlack;

final class SendNewThreadNotification
{
    public function handle(ThreadWasCreated $event): void
    {
        $thread = $event->thread;

        $thread->user->notify(new PostThreadToSlack($thread)); // @phpstan-ignore-line
    }
}
