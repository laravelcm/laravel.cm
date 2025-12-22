<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Livewire\Pages\Articles\SinglePost;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

/**
 * @var Tests\TestCase $this
 */
beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->tag = Tag::factory()->create(['name' => 'Laravel', 'concerns' => ['post']]);
    $this->article = Article::factory()
        ->for($this->user)
        ->create([
            'title' => 'Test Article Title',
            'body' => 'This is a test article content.',
            'published_at' => now(),
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);
    $this->article->tags()->attach($this->tag);
});

describe(SinglePost::class, function (): void {
    it('displays published article for guests', function (): void {
        Livewire::test(SinglePost::class, ['article' => $this->article])
            ->assertStatus(200)
            ->assertSee($this->article->title)
            ->assertSee($this->article->body)
            ->assertSee($this->user->name);
    });

    it('displays published article for authenticated users', function (): void {
        $this->actingAs($this->user);

        Livewire::test(SinglePost::class, ['article' => $this->article])
            ->assertStatus(200)
            ->assertSee($this->article->title)
            ->assertSee($this->article->body);
    });

    it('prevents access to unpublished article for guests', function (): void {
        $unpublishedArticle = Article::factory()
            ->for($this->user)
            ->create(['published_at' => null]);

        Livewire::test(SinglePost::class, ['article' => $unpublishedArticle])
            ->assertStatus(404);
    });

    it('allows author to view their unpublished article', function (): void {
        $unpublishedArticle = Article::factory()
            ->for($this->user)
            ->create(['published_at' => null]);

        $this->actingAs($this->user);

        Livewire::test(SinglePost::class, ['article' => $unpublishedArticle])
            ->assertStatus(200)
            ->assertSee($unpublishedArticle->title);
    });

    it('allows admin to view any unpublished article', function (): void {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin->value);

        $unpublishedArticle = Article::factory()
            ->for($this->user)
            ->create();

        $this->actingAs($admin);

        Livewire::test(SinglePost::class, ['article' => $unpublishedArticle])
            ->assertStatus(200)
            ->assertSee($unpublishedArticle->title);
    });

    it('allows moderator to view any unpublished article', function (): void {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator->value);

        $unpublishedArticle = Article::factory()
            ->for($this->user)
            ->create();

        $this->actingAs($moderator);

        Livewire::test(SinglePost::class, ['article' => $unpublishedArticle])
            ->assertStatus(200)
            ->assertSee($unpublishedArticle->title);
    });

    it('caches article data on first load', function (): void {
        Cache::flush();

        expect(Cache::has('article.'.$this->article->id))->toBeFalse();

        Livewire::test(SinglePost::class, ['article' => $this->article])
            ->assertStatus(200);

        expect(Cache::has('article.'.$this->article->id))->toBeTrue();

        $cachedArticle = Cache::get('article.'.$this->article->id);
        expect($cachedArticle->id)->toBe($this->article->id)
            ->and($cachedArticle->relationLoaded('user'))->toBeTrue()
            ->and($cachedArticle->relationLoaded('tags'))->toBeTrue()
            ->and($cachedArticle->relationLoaded('media'))->toBeTrue();
    });

    it('uses cached article data on subsequent loads', function (): void {
        Cache::flush();

        expect(Cache::has('article.'.$this->article->id))->toBeFalse();

        Livewire::test(SinglePost::class, ['article' => $this->article]);

        expect(Cache::has('article.'.$this->article->id))->toBeTrue();

        $cachedArticle = Cache::get('article.'.$this->article->id);
        expect($cachedArticle)->not->toBeNull()
            ->and($cachedArticle->title)->toBe('Test Article Title');
    });

    it('records view for published articles', function (): void {
        $initialViews = $this->article->views()->count();

        Livewire::test(SinglePost::class, ['article' => $this->article]);

        expect($this->article->views()->count())->toBeGreaterThan($initialViews);
    });

    it('does not record view for unpublished articles', function (): void {
        $unpublishedArticle = Article::factory()
            ->for($this->user)
            ->create();

        $this->actingAs($this->user);

        $initialViews = $unpublishedArticle->views()->count();

        Livewire::test(SinglePost::class, ['article' => $unpublishedArticle]);

        expect($unpublishedArticle->views()->count())->toBe($initialViews);
    });

    it('sets correct SEO meta tags', function (): void {
        Livewire::test(SinglePost::class, ['article' => $this->article])
            ->assertStatus(200);

        expect(seo()->getTitle())->toContain($this->article->title);
    });

    it('displays article tags', function (): void {
        Livewire::test(SinglePost::class, ['article' => $this->article])
            ->assertStatus(200)
            ->assertSee($this->tag->name);
    });

    it('invalidates cache when article is updated', function (): void {
        Livewire::test(SinglePost::class, ['article' => $this->article]);
        expect(Cache::has('article.'.$this->article->id))->toBeTrue();

        Cache::forget('article.'.$this->article->id);

        $this->article->update(['title' => 'Updated Title']);

        expect(Cache::has('article.'.$this->article->id))->toBeFalse();

        Livewire::test(SinglePost::class, ['article' => $this->article->fresh()])
            ->assertStatus(200)
            ->assertSee('Updated Title');

        expect(Cache::has('article.'.$this->article->id))->toBeTrue();
    });
})->group('articles');
