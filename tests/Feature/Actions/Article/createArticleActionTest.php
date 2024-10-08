<?php


declare(strict_types=1);

use App\Actions\Article\CreateArticleAction;
use App\Data\Article\CreateArticleData;
use App\Models\Article;
use App\Models\Tag;


beforeEach(function (): void {
    $this->user = $this->login();
    $this->tagOne = Tag::factory()->create(['name' => 'Tag 1', 'concerns' => ['article']]);
    $this->tagTwo = Tag::factory()->create(['name' => 'Tag 2', 'concerns' => ['article', 'post']]);
});


describe(CreateArticleAction::class, function (): void {
    it('return the created article', function (): void {
        $articleDataWithoutTag = CreateArticleData::from([
            'title' => 'Article title',
            'slug' => 'Article slug',
            'published_at' => Now(),
            'submitted_at' => null,
            'approved_at' => null,
            'show_toc' => 'Article show_toc',
            'canonical_url' => 'Article canonical_url',
            'body' => 'Article body',
            'associateTags' => [],
        ]);

        $article = app(CreateArticleAction::class)->execute($articleDataWithoutTag);

        expect($article)
            ->toBeInstanceOf(Article::class)
            ->and($article->tags)
            ->toHaveCount(0)
            ->and($article->user_id)
            ->toBe($this->user->id);
    });
})->group('Articles');
