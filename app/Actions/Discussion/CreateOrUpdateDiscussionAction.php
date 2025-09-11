<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

final class CreateOrUpdateDiscussionAction
{
    public function handle(array $formValues, ?int $discussionId = null): Discussion
    {
        return DB::transaction(function () use ($formValues, $discussionId): Discussion {
            /** @var Discussion $discussion */
            $discussion = Discussion::query()->updateOrCreate(
                ['id' => $discussionId],
                $formValues
            );

            if (blank($discussionId)) {
                givePoint(new DiscussionCreated($discussion));
            }

            return $discussion;
        });
    }
}
