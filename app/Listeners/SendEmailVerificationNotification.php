<?php

namespace App\Listeners;

use App\Events\EmailAddressWasChanged;

final class SendEmailVerificationNotification
{
    public function handle(EmailAddressWasChanged $event): void
    {
        $event->user->sendEmailVerificationNotification();
    }
}
