<?php

namespace App\Listeners;

use App\Jobs\SendBanEmailJob;
use App\Events\UserBannedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBanNotificationListener
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