<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ThreadPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function manage(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function update(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user);
    }

    public function delete(User $user, Thread $thread): bool
    {
        return $thread->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function subscribe(User $user, Thread $thread): bool
    {
        return ! $thread->hasSubscriber($user);
    }

    public function unsubscribe(User $user, Thread $thread): bool
    {
        return $thread->hasSubscriber($user);
    }

    public function report(User $user, Thread $thread): bool
    {
        return $user->hasVerifiedEmail() && ! $thread->isAuthoredBy($user);
    }
}
