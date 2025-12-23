<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Models\Discussion;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class ConvertDiscussionToThreadAction
{
    public function execute(Discussion $discussion): Thread
    {
        return DB::transaction(function () use ($discussion) {
            $thread = Thread::query()->create([
                'title' => $discussion->title,
                'slug' => $discussion->slug,
                'body' => $discussion->body,
                'user_id' => $discussion->user_id,
                'last_posted_at' => $discussion->created_at,
            ]);

            $discussion->replies()->update([
                'replyable_type' => 'thread',
                'replyable_id' => $thread->id,
            ]);

            $discussion->delete();

            resolve(NotifyUsersOfThreadConversionAction::class)->execute($thread);

            return $thread;
        });
    }
}
