<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    public function ban(User $user): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function unban(User $user): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }
}
