<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadConvertedByAdmin;
use App\Notifications\ThreadConvertedByCreator;
use Illuminate\Support\Facades\Auth;

final class NotifyUsersOfThreadConversionAction
{
    public function execute(Thread $thread): void
    {
        $usersToNotify = $thread->replies()->pluck('user_id')->unique()->toArray();

        User::query()->whereIn('id', $usersToNotify)
            ->get()
            ->each
            ->notify(new ThreadConvertedByCreator($thread));

        if (Auth::check() && (Auth::user()?->isAdmin() || Auth::user()?->isModerator())) {
            $thread->user->notify(new ThreadConvertedByAdmin($thread));
        }
    }
}
