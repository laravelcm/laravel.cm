<?php

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\User;
use App\Notifications\NewReplyNotification;

class SendNewReplyNotification
{
    public function handle(ReplyWasCreated $event)
    {
        /** @var \App\Models\Thread $thread */
        $thread = $event->reply->replyAble;

        foreach ($thread->subscribes as $subscription) {
            if ($this->replyAuthorDoesNotMatchSubscriber($event->reply->author, $subscription)) {
                $subscription->user->notify(new NewReplyNotification($event->reply, $subscription));
            }
        }
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, $subscription): bool
    {
        return ! $author->is($subscription->user);
    }
}
