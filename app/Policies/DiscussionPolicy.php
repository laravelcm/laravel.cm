<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;

final class DiscussionPolicy
{
    public const UPDATE = 'update';

    public const DELETE = 'delete';

    public const PINNED = 'togglePinnedStatus';

    public const SUBSCRIBE = 'subscribe';

    public const UNSUBSCRIBE = 'unsubscribe';

    public function update(User $user, Discussion $discussion): bool
    {
        return $discussion->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function delete(User $user, Discussion $discussion): bool
    {
        return $discussion->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function togglePinnedStatus(User $user, Discussion $discussion): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }

    public function subscribe(User $user, Discussion $discussion): bool
    {
        return ! $discussion->hasSubscriber($user);
    }

    public function unsubscribe(User $user, Discussion $discussion): bool
    {
        return $discussion->hasSubscriber($user);
    }
}
