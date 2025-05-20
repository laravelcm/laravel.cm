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

    public function update(User $user, Discussion $discussion): bool
    {
        return $discussion->user_id === $user->id;
    }

    public function delete(User $user, Discussion $discussion): bool
    {
        if ($discussion->user_id === $user->id) {
            return true;
        }

        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function manage(User $user, Discussion $discussion): bool
    {
        if ($discussion->user_id === $user->id) {
            return true;
        }

        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function togglePinnedStatus(User $user): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
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
