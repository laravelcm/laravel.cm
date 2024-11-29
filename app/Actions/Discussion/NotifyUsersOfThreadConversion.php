<?php

namespace App\Actions\Discussion;

use App\Models\Thread;
use App\Notifications\ThreadConvertedByAdmin;
use App\Notifications\ThreadConvertedByCreator;
use Illuminate\Support\Facades\Mail;

class NotifyUsersOfThreadConversion
{
    public function execute(Thread $thread, bool $isAdmin = false): void
    {
        $usersToNotify = $thread->replies->pluck('user')->unique();

        // ToDo: send mail to the replying user with this class notification ThreadConvertedByCreator

        if ($isAdmin) {
            $creator = $thread->user;
            // ToDo: send mail to the creator with this class notification ThreadConvertedByAdmin
        }
    }
}
