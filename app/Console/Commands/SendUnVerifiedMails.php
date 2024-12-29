<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\SendMailToUnVerifiedUsers;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendUnVerifiedMails extends Command
{
    protected $signature = 'lcd:send-unverified-mails';

    protected $description = 'Send mails to unverified users to prevent from a deletion account.';

    public function handle(): void
    {
        foreach (User::unVerifiedUsers()->get() as $user) {
            Mail::to($user)->send(new SendMailToUnVerifiedUsers($user));
        }
    }
}
