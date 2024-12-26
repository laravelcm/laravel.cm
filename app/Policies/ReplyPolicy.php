<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ReplyPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) && $user->hasVerifiedEmail();
    }

    public function delete(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function report(User $user, Reply $reply): bool
    {
        return $user->hasVerifiedEmail() && ! $reply->isAuthoredBy($user);
    }

    public function like(User $user, Reply $reply): bool
    {
        return $user->hasVerifiedEmail();
    }
}
