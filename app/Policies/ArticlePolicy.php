<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ArticlePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

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
        if ($article->user_id === $user->id) {
            return true;
        }

        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function approve(User $user): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->isAdmin();
    }

    public function decline(User $user): bool
    {
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
}
