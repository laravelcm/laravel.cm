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
        if ($user->isAdmin() || $user->isModerator()) {
            throw new CannotBanAdminException('Impossible de bannir un administrateur.');
        }

        if ($user->banned()) {
            throw new UserAlreadyBannedException('Impossible de bannir cet utilisateur car il est déjà banni.');
        }

        $user->update([
            'banned_at' => now(),
            'banned_reason' => $reason,
        ]);

        event(new UserBannedEvent($user));
    }
}
