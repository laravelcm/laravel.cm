<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ArticlePolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Article $article): bool
    {
        return $article->user_id === $user->id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $article->user_id === $user->id || $user->isModerator() || $user->isAdmin();
    }

    public function approve(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }

    public function decline(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }

    public function togglePinnedStatus(User $user, Article $article): bool
    {
        return $user->isModerator() || $user->isAdmin();
    }
}
