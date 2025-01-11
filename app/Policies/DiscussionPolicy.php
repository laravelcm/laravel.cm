<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DiscussionPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function manage(User $user, Discussion $discussion): bool
    {
        return $discussion->user_id === $user->id || $user->isModerator() || $user->isAdmin();
    }

    public function update(User $user, Discussion $discussion): bool
    {
        return $discussion->user_id === $user->id;
    }

    public function delete(User $user, Discussion $discussion): bool
    {
        return $discussion->user_id === $user->id || $user->isModerator() || $user->isAdmin();
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
        return $user->hasVerifiedEmail() && $discussion->user_id !== $user->id;
    }

    public function convertedToThread(User $user, Discussion $discussion): bool
    {
        return $discussion->user_id === $user->id || $user->isAdmin();
    }
}
