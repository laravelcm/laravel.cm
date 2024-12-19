<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class UpdateThreadAction
{
    public function execute(array $formValues, int $threadId): Thread
    {
        return DB::transaction(function () use ($formValues, $threadId) {

            $thread = Thread::query()->findOrFail($threadId);

            $thread->update($formValues);

            return $thread;
        });

    }
}
