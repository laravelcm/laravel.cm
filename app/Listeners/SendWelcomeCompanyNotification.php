<?php

namespace App\Listeners;

use App\Events\ApiRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeCompanyNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  ApiRegistered  $event
     * @return void
     */
    public function handle(ApiRegistered $event): void
    {
        $user = $event->user;
    }
}
