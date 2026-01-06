<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Events\ThreadWasCreated;
use App\Gamify\Points\ThreadCreated;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateThreadAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function execute(array $data): Thread
    {
        return DB::transaction(function () use ($data) {
            $thread = Thread::query()->create($data);

            resolve(SubscribeToThreadAction::class)->execute($thread);

            givePoint(new ThreadCreated($thread));
            event(new ThreadWasCreated($thread));

            return $thread;
        });
    }
}
