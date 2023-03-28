<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReplyWasCreated;
use App\Models\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    public function handle(ReplyWasCreated $event)
    {
        User::whereIn('username', $event->reply->mentionedUsers())
            ->get()
            ->each(fn ($user) => $user->notify(new YouWereMentioned($event->reply)));
    }
}
