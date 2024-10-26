<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

final class ReplyPolicy
{
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function manage(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function update(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) && $user->hasVerifiedEmail();
    }

    public function delete(User $user, Reply $reply): bool
    {
        return $reply->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }
}
