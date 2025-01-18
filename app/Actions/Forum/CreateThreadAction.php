<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Events\ThreadWasCreated;
use App\Gamify\Points\ThreadCreated;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class CreateThreadAction
{
    public function execute(array $formValues): Thread
    {
        return DB::transaction(function () use ($formValues) {
            $thread = Thread::query()->create($formValues);

            app(SubscribeToThreadAction::class)->execute($thread);

            givePoint(new ThreadCreated($thread));

            event(new ThreadWasCreated($thread));

            return $thread;
        });
    }
}
