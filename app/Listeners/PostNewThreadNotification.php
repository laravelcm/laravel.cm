<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Notifications\PostThreadToTelegram;

class PostNewThreadNotification
{
    public function handle(ThreadWasCreated $event): void
    {
        $thread = $event->thread;

        $thread->notify(new PostThreadToTelegram());
    }
}
