<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[\Illuminate\Console\Attributes\Description('Send mails to new registered users.')]
#[\Illuminate\Console\Attributes\Signature('lcm:send-welcome-mails')]
final class SendWelcomeMailToUsers extends Command
{
    public function handle(): void
    {
        foreach (User::all() as $user) {
            Mail::to($user)->queue(new Welcome($user));
        }
    }
}
