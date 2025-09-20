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

        $media = $user->getMedia('avatar')->first();

        $avatar_type = match ($user->avatar_type) {
            'storage' => $media,
            'avatar' => ! $media && $user->providers->isEmpty(),
        };

        if (! $media && $user->providers->isNotEmpty()) {
            $avatar_type = $user->providers->first()->provider;
        }

        $user->saveQuietly([
            'avatar_type' => $avatar_type,
        ]);
    }
}
