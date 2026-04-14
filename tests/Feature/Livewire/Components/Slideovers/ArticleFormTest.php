<?php

declare(strict_types=1);

use App\Events\ArticleWasSubmittedForApproval;
use App\Livewire\Components\Slideovers\ArticleForm;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

describe(ArticleForm::class, function (): void {
    it('return redirect to unauthenticated user', function (): void {
        Livewire::test(ArticleForm::class)
            ->assertStatus(302);
    });

    it('dispatches telegram notification only on first submission', function (): void {
        Event::fake([ArticleWasSubmittedForApproval::class]);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $tag = Tag::factory()->create(['concerns' => ['post']]);

        Livewire::actingAs($user)
            ->test(ArticleForm::class)
            ->set('form.title', 'Mon premier article de test')
            ->set('form.slug', 'mon-premier-article-de-test')
            ->set('form.body', 'Contenu de mon article suffisamment long pour la validation')
            ->set('form.locale', 'fr')
            ->set('form.is_draft', false)
            ->set('form.published_at', now()->format('Y-m-d'))
            ->set('form.tags', [$tag->id])
            ->call('save');

        Event::assertDispatchedTimes(ArticleWasSubmittedForApproval::class, 1);
    });

    it('does not re-dispatch telegram notification when updating a submitted article', function (): void {
        Event::fake([ArticleWasSubmittedForApproval::class]);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $tag = Tag::factory()->create(['concerns' => ['post']]);
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'submitted_at' => now(),
            'published_at' => now(),
        ]);
        $article->tags()->sync([$tag->id]);

        Livewire::actingAs($user)
            ->test(ArticleForm::class, ['articleId' => $article->id])
            ->set('form.title', 'Titre modifié de mon article')
            ->set('form.slug', $article->slug)
            ->set('form.body', 'Contenu modifié de mon article suffisamment long')
            ->set('form.locale', 'fr')
            ->set('form.is_draft', false)
            ->set('form.published_at', now()->format('Y-m-d'))
            ->set('form.tags', [$tag->id])
            ->call('save');

        Event::assertNotDispatched(ArticleWasSubmittedForApproval::class);
    });
})->group('articles');
