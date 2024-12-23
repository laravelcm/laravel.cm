<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Gamify\Points\ArticlePublished;
use App\Models\Article;

final class ApprovedArticleAction
{
    public function execute(Article $article): Article
    {
        $article->approved_at = now();
        $article->save();

        givePoint(new ArticlePublished($article));

        return $article;
    }
}
