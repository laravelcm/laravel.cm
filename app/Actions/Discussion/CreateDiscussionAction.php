<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Data\Discussion\CreateDiscussionData;
use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use App\Notifications\PostDiscussionToTelegram;
use Illuminate\Support\Facades\Auth;

final class CreateDiscussionAction
{
    public function execute(CreateDiscussionData $discussionData): Discussion
    {
        /** @var Discussion $discussion */
        $discussion = Discussion::query()->create([
            'title' => $discussionData->title,
            'slug' => $discussionData->title,
            'body' => $discussionData->body,
            'user_id' => Auth::id(),
        ]);

        if (collect($discussionData->tags)->isNotEmpty()) {
            $discussion->syncTags($discussionData->tags);
        }

        givePoint(new DiscussionCreated($discussion));

        Auth::user()?->notify(new PostDiscussionToTelegram($discussion));

        return $discussion;
    }
}
