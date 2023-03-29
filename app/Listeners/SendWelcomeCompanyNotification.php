<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ApiRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class SendWelcomeCompanyNotification implements ShouldQueue
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
