<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\UserUnbannedEvent;
use App\Models\User;

final class UnBanUserAction
{
    public function execute(User $user): void
    {
        $user->update([
            'banned_at' => null,
            'banned_reason' => null,
        ]);

        event(new UserUnbannedEvent($user));
    }
}
