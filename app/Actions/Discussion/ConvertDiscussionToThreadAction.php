<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Models\Discussion;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class ConvertDiscussionToThreadAction
{
    public function execute(Discussion $discussion, bool $isAdmin = false): Thread
    {
        return DB::transaction(function () use ($discussion, $isAdmin) {
            $thread = Thread::create([
                'title' => $discussion->title,
                'slug' => $discussion->slug,
                'body' => $discussion->body,
                'user_id' => $discussion->user_id,
                'locked' => $discussion->locked,
                'last_posted_at' => now(),
            ]);

            $discussion->replies()->update([
                'replyable_type' => 'thread',
                'replyable_id' => $thread->id,
            ]);

            $discussion->delete();

            app(NotifyUsersOfThreadConversion::class)->execute($thread, $isAdmin);

            return $thread;
        });
    }
}
