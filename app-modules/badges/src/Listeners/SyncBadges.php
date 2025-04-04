<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Listeners;

use Laravelcm\Badges\Events\ReputationChanged;

final class SyncBadges
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ReputationChanged $event): void
    {
        $event->user->syncBadges();
    }
}
