<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailToUsers extends Command
{
    protected $signature = 'lcm:send-welcome-mails';

    protected $description = 'Send mails to new registered users.';

    public function handle(): void
    {
        foreach (User::all() as $user) {
            Mail::to($user)->queue(new Welcome($user));
        }
    }
}
