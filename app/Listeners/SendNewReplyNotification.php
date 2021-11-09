<?php

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\User;

class SendNewReplyNotification
{
    public function handle(ReplyWasCreated $event)
    {
        /** @var \App\Models\Thread $thread */
        $thread = $event->reply->replyAble();
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, $subscription): bool
    {
        return ! $author->is($subscription->user());
    }
}
