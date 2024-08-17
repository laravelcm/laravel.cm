<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ApiRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class SendCompanyEmailVerificationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ApiRegistered $event): void
    {
        $user = $event->user;
    }
}
