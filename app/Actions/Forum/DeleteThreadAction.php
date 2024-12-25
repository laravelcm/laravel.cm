<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Gamify\Points\ThreadCreated;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class DeleteThreadAction
{
    public function execute(Thread $thread): void
    {
        DB::beginTransaction();

        undoPoint(new ThreadCreated($thread));

        $thread->delete();

        DB::commit();
    }
}
