<?php

declare(strict_types=1);

use App\Actions\Article\CreateArticleAction;
use App\Data\CreateArticleData;
use App\Models\Article;
use App\Models\Tag;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->tagOne = Tag::factory()->create(['name' => 'Tag 1', 'concerns' => ['post']]);
    $this->tagTwo = Tag::factory()->create(['name' => 'Tag 2', 'concerns' => ['tutorial', 'post']]);
});

describe(CreateArticleAction::class, function (): void {
    it('return the created article', function (): void {
        $articleDataWithoutTag = CreateArticleData::from([
            'title' => 'Article title',
            'slug' => 'Article slug',
            'publishedAt' => now(),
            'submittedAt' => null,
            'approvedAt' => null,
            'showToc' => 'Article show_toc',
            'canonicalUrl' => 'Article canonical_url',
            'body' => 'Article body',
            'tags' => [$this->tagOne->id, $this->tagTwo->id],
        ]);

        $article = app(CreateArticleAction::class)->execute($articleDataWithoutTag);

        expect($article)
            ->toBeInstanceOf(Article::class)
            ->and($article->tags)
            ->toHaveCount(2)
            ->and($article->user_id)
            ->toBe($this->user->id);
    });
})->group('Articles');
