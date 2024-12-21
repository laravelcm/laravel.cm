<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Data\ArticleData;
use App\Exceptions\CannotUpdateApprovedArticle;
use App\Models\Article;
use Carbon\Carbon;

final class UpdateArticleAction
{
    public function execute(ArticleData $articleData, Article $article): Article
    {
        if ($article->isApproved()) {
            throw new CannotUpdateApprovedArticle(__('notifications.exceptions.approved_article'));
        }

        if ($articleData->published_at) {
            $articleData->published_at = new Carbon(
                time: $articleData->published_at,
                timezone: config('app.timezone')
            );
        }

        if ($articleData->submitted_at) {
            $articleData->submitted_at = new Carbon(
                time: $articleData->submitted_at,
                timezone: config('app.timezone')
            );
        }

        $article->update($articleData->toArray());

        $article->refresh();

        return $article;
    }
}
