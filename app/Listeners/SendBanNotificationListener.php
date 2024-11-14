<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserBannedEvent;
use App\Jobs\SendBanEmailJob;

final class SendBanNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserBannedEvent $event): void
    {
        SendBanEmailJob::dispatch($event->user);
    }
}
