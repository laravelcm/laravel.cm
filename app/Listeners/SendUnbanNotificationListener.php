<?php

namespace App\Listeners;

use App\Jobs\SendUnbanEmailJob;
use App\Events\UserUnbannedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUnbanNotificationListener
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
    public function handle(UserUnbannedEvent $event): void
    {
        SendUnbanEmailJob::dispatch($event->user);
    }
}