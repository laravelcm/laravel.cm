<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Events\ThreadWasCreated;
use App\Gamify\Points\ThreadCreated;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class CreateOrUpdateThreadAction
{
    public function execute(array $formValues, ?Thread $thread = null): Thread
    {
        return DB::transaction(function () use ($formValues, $thread) {
            $edit = (bool) $thread?->id;
            $thread = Thread::query()->updateOrCreate(['id' => $thread?->id], $formValues);

            if (! $edit) {
                app(SubscribeToThreadAction::class)->execute($thread);

                givePoint(new ThreadCreated($thread));

                event(new ThreadWasCreated($thread));
            }

            return $thread;
        });

    }
}
