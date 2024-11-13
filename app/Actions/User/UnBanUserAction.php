<?php

namespace App\Actions\User;

use App\Models\User;
use App\Events\UserUnbannedEvent;

final class UnBanUserAction
{
    public function execute(User $user) : void
    {
        $user->banned_at = null;
        $user->banned_reason = null;
        $user->save();
        
        event(new UserUnbannedEvent($user));
    }
}