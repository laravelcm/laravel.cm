<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\UserBannedEvent;
use App\Exceptions\CannotBanAdminException;
use App\Exceptions\UserAlreadyBannedException;
use App\Models\User;

final class BanUserAction
{
    public function execute(User $user, string $reason): void
    {
        if ($user->hasRole('admin')) {
            throw new CannotBanAdminException;
        }

        if ($user->banned_at !== null) {
            throw new UserAlreadyBannedException;
        }

        $user->update([
            'banned_at' => now(),
            'banned_reason' => $reason,
        ]);

        event(new UserBannedEvent($user));
    }
}
