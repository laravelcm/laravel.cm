<?php

namespace App\Listeners;

use App\Events\ThreadWasCreated;
use App\Notifications\PostThreadToSlack;

class SendNewThreadNotification
{
    public function handle(ThreadWasCreated $event)
    {
        $thread = $event->thread;

        $thread->author->notify(new PostThreadToSlack($thread));
    }
}
