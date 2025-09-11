<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserBannedEvent;
use App\Jobs\SendBanEmailJob;

final class SendBanNotificationListener
{
    public function handle(UserBannedEvent $event): void
    {
        dispatch(new SendBanEmailJob($event->user));
    }
}
