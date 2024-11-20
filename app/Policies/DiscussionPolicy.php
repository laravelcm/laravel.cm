<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DiscussionPolicy
{
    use HandlesAuthorization;

    public const UPDATE = 'update';

    public const DELETE = 'delete';

    public const PINNED = 'togglePinnedStatus';

    public const SUBSCRIBE = 'subscribe';

    public const UNSUBSCRIBE = 'unsubscribe';

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

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

    public function report(User $user, Discussion $discussion): bool
    {
        return $user->hasVerifiedEmail() && ! $discussion->isAuthoredBy($user);
    }
}
