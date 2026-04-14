<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Gamify\Points\ArticlePublished;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;

final class ApprovedArticleAction
{
    public function execute(Article $article): Article
    {
        $article->update(['approved_at' => now()]);

        givePoint(new ArticlePublished($article));

        Cache::tags(['home', 'articles'])->flush();

        return $article;
    }
}
