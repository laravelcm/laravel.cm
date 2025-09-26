<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Gamify\Points\ArticlePublished;
use App\Models\Article;

final class ApprovedArticleAction
{
    public function execute(Article $article): Article
    {
        $article->update(['approved_at' => now()]);

        givePoint(new ArticlePublished($article));

        return $article;
    }
}
