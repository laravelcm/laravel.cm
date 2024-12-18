<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

final class DeleteDiscussionAction
{
    public function execute(Discussion $discussion): void
    {
        DB::beginTransaction();

        undoPoint(new DiscussionCreated($discussion));
        $discussion->delete();

        DB::commit();
    }
}
