<?php

namespace App\Actions\User;

use App\Models\User;
use App\Events\UserUnbannedEvent;

final class UnBanUserAction
{
    public function execute(User $user) : void
    {
        $user->update([
            'banned_at' => null,
            'banned_reason' => null
        ]);
        
        event(new UserUnbannedEvent($user));
    }
}