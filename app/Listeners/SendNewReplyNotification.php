<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\Subscribe;
use App\Models\User;
use App\Notifications\NewReplyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class SendNewReplyNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReplyWasCreated $event): void
    {
        /** @var \App\Models\Thread $thread */
        $thread = $event->reply->replyAble;

        foreach ($thread->subscribes as $subscription) {
            if ($this->replyAuthorDoesNotMatchSubscriber($event->reply->user, $subscription)) {
                $subscription->user->notify(new NewReplyNotification($event->reply, $subscription));
            }
        }
    }

    private function replyAuthorDoesNotMatchSubscriber(User $author, Subscribe $subscription): bool
    {
        return ! $author->is($subscription->user);
    }
}
