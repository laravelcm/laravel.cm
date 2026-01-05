<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\ArticleData;
use App\Exceptions\CannotUpdateApprovedArticle;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;

final class UpdateArticleAction
{
    public function execute(ArticleData $data, Article $article, User $user): Article
    {
        if ($article->isApproved()) {
            throw new CannotUpdateApprovedArticle(__('notifications.exceptions.approved_article'));
        }

        if ($data->declined_at instanceof Carbon) {
            $data->declined_at = null;
        }

        if (filled($data->published_at) && ($user->isAdmin() || $user->isModerator())) {
            $data->approved_at = now();
        }

        $article->update($data->toArray());

        $article->refresh();

        return $article;
    }
}
