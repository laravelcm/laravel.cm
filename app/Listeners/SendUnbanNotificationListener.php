<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserUnbannedEvent;
use App\Jobs\SendUnbanEmailJob;

final class SendUnbanNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(UserUnbannedEvent $event): void
    {
        dispatch(new SendUnbanEmailJob($event->user));
    }
}
