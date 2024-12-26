<?php

declare(strict_types=1);

use App\Actions\Article\UpdateArticleAction;
use App\Data\ArticleData;
use App\Exceptions\CannotUpdateApprovedArticle;
use App\Models\Article;
use Spatie\TestTime\TestTime;

beforeEach(function (): void {
    $this->user = $this->login();

    TestTime::freeze('Y-m-d H:i:s', '2024-12-20 00:00:01');
});

describe(UpdateArticleAction::class, function (): void {
    it('should update article', function (): void {
        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $updatedArticle = app(UpdateArticleAction::class)->execute(
            articleData: ArticleData::from(array_merge(
                $article->toArray(),
                [
                    'title' => 'Update Article title',
                    'published_at' => now(),
                    'canonical_url' => 'Article canonical_url',
                ]
            )),
            article: $article
        );

        $article->refresh();

        expect($updatedArticle->title)
            ->toBe('Update Article title')
            ->and($article)->toBe($updatedArticle);
    });

    it('should not update an approved article', function (): void {
        /** @var Article $article */
        $article = Article::factory()->approved()->create(['user_id' => $this->user->id]);

        app(UpdateArticleAction::class)->execute(
            articleData: ArticleData::from(array_merge(
                $article->toArray(),
                [
                    'title' => 'Update Article title',
                    'published_at' => now()->addDay(),
                    'canonical_url' => 'Article canonical_url',
                ]
            )),
            article: $article
        );
    })->skip()->expectException(CannotUpdateApprovedArticle::class);
});
