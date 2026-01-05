<?php

declare(strict_types=1);

use App\Actions\Article\UpdateArticleAction;
use App\Data\ArticleData;
use App\Enums\UserRole;
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

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Update Article title',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => now(),
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => 'Article canonical_url',
            ]),
            article: $article,
            user: $this->user
        );

        $article->refresh();

        expect($updatedArticle->title)
            ->toBe('Update Article title')
            ->and($article)->toBe($updatedArticle);
    });

    it('should not update an approved article', function (): void {
        /** @var Article $article */
        $article = Article::factory()->approved()->create(['user_id' => $this->user->id]);

        resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Update Article title',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => now()->addDay(),
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => 'Article canonical_url',
            ]),
            article: $article,
            user: $this->user
        );
    })->throws(CannotUpdateApprovedArticle::class);

    it('should auto-approve article when user is admin and published_at is filled', function (): void {
        $admin = $this->createAdmin();

        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $admin->id,
            'approved_at' => null,
        ]);

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Updated by Admin',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => now(),
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => $article->canonical_url,
            ]),
            article: $article,
            user: $admin
        );

        expect($updatedArticle->approved_at)->not->toBeNull()
            ->and($updatedArticle->approved_at->format('Y-m-d H:i:s'))->toBe('2024-12-20 00:00:01');
    });

    it('should auto-approve article when user is moderator and published_at is filled', function (): void {
        $moderator = $this->createUser();
        $moderator->assignRole(UserRole::Moderator->value);

        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $moderator->id,
            'approved_at' => null,
        ]);

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Updated by Moderator',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => now(),
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => $article->canonical_url,
            ]),
            article: $article,
            user: $moderator
        );

        expect($updatedArticle->approved_at)->not->toBeNull()
            ->and($updatedArticle->approved_at->format('Y-m-d H:i:s'))->toBe('2024-12-20 00:00:01');
    });

    it('should not auto-approve article when user is regular user even if published_at is filled', function (): void {
        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $this->user->id,
            'approved_at' => null,
        ]);

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Updated by Regular User',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => now(),
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => $article->canonical_url,
            ]),
            article: $article,
            user: $this->user
        );

        expect($updatedArticle->approved_at)->toBeNull();
    });

    it('should not auto-approve draft article even for admin when published_at is null', function (): void {
        $admin = $this->createAdmin();

        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $admin->id,
            'approved_at' => null,
            'published_at' => null,
        ]);

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Draft Article Updated',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => null,
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => $article->canonical_url,
            ]),
            article: $article,
            user: $admin
        );

        expect($updatedArticle->approved_at)->toBeNull();
    });

    it('should reset declined_at when updating article', function (): void {
        /** @var Article $article */
        $article = Article::factory()->create([
            'user_id' => $this->user->id,
            'declined_at' => now()->subDay(),
        ]);

        expect($article->declined_at)->not->toBeNull();

        $updatedArticle = resolve(UpdateArticleAction::class)->execute(
            data: ArticleData::from([
                'title' => 'Article Re-submitted',
                'slug' => $article->slug,
                'body' => $article->body,
                'locale' => $article->locale,
                'published_at' => $article->published_at,
                'submitted_at' => $article->submitted_at,
                'declined_at' => $article->declined_at,
                'approved_at' => $article->approved_at,
                'canonical_url' => $article->canonical_url,
            ]),
            article: $article,
            user: $this->user
        );

        expect($updatedArticle->declined_at)->toBeNull();
    });
});
