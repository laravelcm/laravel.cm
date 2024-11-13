<?php

namespace App\Actions\User;

use App\Models\User;
use App\Events\UserBannedEvent;

final class BanUserAction
{
    public function execute(User $user, string $reason): void
    {
        if($user->banned_at == null) {
            $user->banned_at = now();
            $user->banned_reason = $reason;
            $user->save();

            event(new UserBannedEvent($user));
        }
    }
}