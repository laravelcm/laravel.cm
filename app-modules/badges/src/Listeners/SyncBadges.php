<?php

declare(strict_types=1);

namespace QCod\Gamify\Listeners;

use QCod\Gamify\Events\ReputationChanged;

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
