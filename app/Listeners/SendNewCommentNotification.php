<?php

namespace App\Listeners;

use App\Events\CommentWasAdded;
use App\Models\User;
use App\Notifications\NewCommentNotification;

class SendNewCommentNotification
{
    public function handle(CommentWasAdded $event)
    {
        $discussion = $event->discussion;

        foreach ($discussion->subscribes as $subscription) {
            if ($this->replyAuthorDoesNotMatchSubscriber($event->reply->author, $subscription)) {
                $subscription->user->notify(new NewCommentNotification($event->reply, $subscription, $discussion));
            }
        }
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, $subscription): bool
    {
        return ! $author->is($subscription->user);
    }
}
