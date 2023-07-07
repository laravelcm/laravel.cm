<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

final class ArticlePolicy
{
    public const UPDATE = 'update';

    public const DELETE = 'delete';

    public const APPROVE = 'approve';

    public const DISAPPROVE = 'disapprove';

    public const PINNED = 'togglePinnedStatus';

    public function update(User $user, Article $article): bool
    {
        return $article->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function delete(User $user, Article $article): bool
    {
        return $article->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function approve(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }

    public function disapprove(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }

    public function togglePinnedStatus(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }
}
