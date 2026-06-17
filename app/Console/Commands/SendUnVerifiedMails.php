<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\SendMailToUnVerifiedUsers;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[\Illuminate\Console\Attributes\Description('Send mails to unverified users to prevent from a deletion account.')]
#[\Illuminate\Console\Attributes\Signature('lcm:send-unverified-mails')]
final class SendUnVerifiedMails extends Command
{
    public function handle(): void
    {
        foreach (User::query()->scopes('unVerifiedUsers')->get() as $user) {
            Mail::to($user)->send(new SendMailToUnVerifiedUsers($user));
        }
    }
}
