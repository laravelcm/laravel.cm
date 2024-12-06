<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadConvertedByAdmin;
use App\Notifications\ThreadConvertedByCreator;

final class NotifyUsersOfThreadConversion
{
    public function execute(Thread $thread, bool $isAdmin = false): void
    {
        $usersToNotify = $thread->replies()->pluck('user_id')->unique()->toArray();

        User::whereIn('id', $usersToNotify)->get()->each->notify(new ThreadConvertedByCreator($thread));

        if ($isAdmin) {
            $creator = $thread->user;

            $creator->notify(new ThreadConvertedByAdmin($thread));
        }
    }
}
