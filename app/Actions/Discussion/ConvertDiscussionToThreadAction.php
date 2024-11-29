<?php

namespace App\Actions\Discussion;

use App\Models\Discussion;
use App\Models\Thread;
use App\Notifications\NotifyUserConvertionDiscussionToThread;
use Illuminate\Support\Facades\DB;

class ConvertDiscussionToThreadAction
{
    public function execute(Discussion $discussion, bool $isAdmin = false): Thread
    {
        return DB::transaction(function () use ($discussion) {
            $thread = Thread::create([
                'title' => $discussion->title,
                'slug' => $discussion->slug,
                'body' => $discussion->body,
                'user_id' => $discussion->user_id,
                'locked' => $discussion->locked,
                'last_posted_at' => now(),
            ]);

            $discussion->replies()->update([
                'replyable_type' => Thread::class,
                'replyable_id' => $thread->id,
            ]);

            $discussion->delete();

            app(NotifyUserConvertionDiscussionToThread::class)->execute($thread, $isAdmin);

            return $thread;
        });
    }
}
