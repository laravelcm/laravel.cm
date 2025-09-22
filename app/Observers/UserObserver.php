<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;

final class UserObserver
{
    public function updated(User $user): void
    {
        if ($user->isDirty(['avatar_type', 'name'])) {
            $user->flushAvatarCache();
        }

        $avatar_type = 'avatar';

        $media = $user->getMedia('avatar')->first();

        if ($media) {
            $avatar_type = 'storage';
        }

        if (! $media && $user->providers->isNotEmpty()) {
            $avatar_type = $user->providers->first()->provider;
        }

        $user->saveQuietly([
            'avatar_type' => $avatar_type,
        ]);
    }
}
