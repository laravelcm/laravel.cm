<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    public function ban(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function unban(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }
}
