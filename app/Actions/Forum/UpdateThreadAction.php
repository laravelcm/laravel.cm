<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Models\Thread;
use Illuminate\Support\Facades\DB;

final class UpdateThreadAction
{
    public function execute(array $formValues, Thread $thread): Thread
    {
        return DB::transaction(function () use ($formValues, $thread) {

            $thread->update($formValues);

            return $thread;
        });

    }
}
