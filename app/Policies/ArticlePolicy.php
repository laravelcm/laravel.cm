<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

final class ArticlePolicy
{
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Article $article): bool
    {
        return $article->isAuthoredBy($user);
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
