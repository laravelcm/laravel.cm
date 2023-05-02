<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\CommentWasAdded;
use App\Models\Subscribe;
use App\Models\User;
use App\Notifications\NewCommentNotification;

final class SendNewCommentNotification
{
    public function handle(CommentWasAdded $event): void
    {
        $discussion = $event->discussion;

        foreach ($discussion->subscribes as $subscription) {
            /** @var Subscribe $subscription */
            // @phpstan-ignore-next-line
            if ($this->replyAuthorDoesNotMatchSubscriber(author: $event->reply->user, subscription: $subscription)) {
                // @phpstan-ignore-next-line
                $subscription->user->notify(new NewCommentNotification(
                    reply: $event->reply,
                    subscription:  $subscription,
                    discussion: $discussion
                ));
            }
        }
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, Subscribe $subscription): bool
    {
        return ! $author->is($subscription->user);
    }
}
