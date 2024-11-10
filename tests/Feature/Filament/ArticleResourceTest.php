<?php

declare(strict_types=1);

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login(['email' => 'joe@laravel.cm']);
    $this->articles = Article::factory()->count(10)->create([
        'submitted_at' => now(),
    ]);
});

describe(ArticleResource::class, function (): void {
    it('page can display table with records', function (): void {
        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->assertCanSeeTableRecords($this->articles);
    })->group('articles');

    it('admin user can approved article', function (): void {
        $article = $this->articles->first();

        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->callTableAction('approved', $article);

        $article->refresh();

        expect($article->approved_at)
            ->not()
            ->toBe(null)
            ->and($article->declined_at)
            ->toBe(null);

        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->assertTableActionHidden('approved', $article)
            ->assertTableActionHidden('declined', $article);
    })->group('articles');

    it('admin user can declined article', function (): void {
        $article = $this->articles->first();

        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->callTableAction('declined', $article);

        $article->refresh();

        expect($article->declined_at)
            ->not
            ->toBe(null)
            ->and($article->approved_at)
            ->toBe(null);

        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->assertTableActionHidden('approved', $article)
            ->assertTableActionHidden('declined', $article);

    })->group('articles');
});
