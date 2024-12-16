<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;

final class UserObserver
{
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $media = $user->getMedia('avatar')->first();

        if ($media) {
            $user->avatar_type = 'storage';
        }

        if (! $media && $user->providers->isNotEmpty()) {
            $user->avatar_type = $user->providers->first()->provider;
        }

        if (! $media && $user->providers->isEmpty()) {
            $user->avatar_type = 'avatar';
        }

        $user->saveQuietly();
    }
}
