<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    public function ban(User $user, User $target): bool
    {
        if ($user->getKey() === $target->getKey()) {
            return false;
        }

        if ($target->isAdmin() && ! $user->isAdmin()) {
            return false;
        }

        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function unban(User $user, User $target): bool
    {
        if ($user->getKey() === $target->getKey()) {
            return false;
        }

        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }
}
