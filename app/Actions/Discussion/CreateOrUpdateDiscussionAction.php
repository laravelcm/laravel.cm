<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateOrUpdateDiscussionAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(array $data, ?int $discussionId = null): Discussion
    {
        return DB::transaction(function () use ($data, $discussionId): Discussion {
            if ($discussionId) {
                /** @var Discussion $discussion */
                $discussion = Discussion::query()->findOrFail($discussionId);
                $discussion->update($data);
                $discussion->refresh();
            } else {
                /** @var Discussion $discussion */
                $discussion = Discussion::query()->create($data);

                givePoint(new DiscussionCreated($discussion));
            }

            return $discussion;
        });
    }
}
