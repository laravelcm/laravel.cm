<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ThreadWasCreated;

final class SendNewThreadNotification
{
    public function handle(ThreadWasCreated $event): void
    {
        // @Todo: Send notification to Discord
    }
}
