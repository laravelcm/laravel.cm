<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserUnbannedEvent;
use App\Jobs\SendUnbanEmailJob;

final class SendUnbanNotificationListener
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
