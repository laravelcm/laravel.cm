<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

final class SendWelcomeMailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        Mail::to($user)->queue(new Welcome($user));
    }
}
