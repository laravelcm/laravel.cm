<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;

class DiscussionPolicy
{
    const UPDATE = 'update';

    const DELETE = 'delete';

    const PINNED = 'togglePinnedStatus';

    const SUBSCRIBE = 'subscribe';

    const UNSUBSCRIBE = 'unsubscribe';

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
