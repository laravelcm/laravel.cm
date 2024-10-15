<?php

declare(strict_types=1);

use App\Filament\Actions\ApprovedAction;
use App\Filament\Actions\DeclinedAction;
use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Filament\Tables\Actions\DeleteAction;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->articles = Article::factory()->count(10)->create([
        'submitted_at' => now()
    ]);
});

describe(ArticleResource::class, function (): void {

    it('page can display table with records', function () {
        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->assertCanSeeTableRecords($this->articles);
    });

    it('table can render columns', function () {
        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->assertCanRenderTableColumn('title')
            ->assertCanRenderTableColumn('status')
            ->assertCanRenderTableColumn('status')
            ->assertCanRenderTableColumn('submitted_at');
    });

    it('admin user  can approved article', function () {
        $article = Article::factory()->create(['submitted_at' => now()]);

        Livewire::test(ArticleResource\Pages\ListArticles::class)
            ->callTableAction('approved', $article);

        $article->refresh();

        expect($article->approved_at)
            ->not
            ->toBe(null);

        expect($article->declined_at)
            ->toBe(null);
    });


    it('admin user can declined article', function () {
        $article = Article::factory()->create(['submitted_at' => now()]);

        Livewire::test(ArticleResource\Pages\ListArticles::class)
          ->callTableAction('declined', $article);

        $article->refresh();

        expect($article->declined_at)
            ->not
            ->toBe(null);

        expect($article->approved_at)
            ->toBe(null);
    });

    // it('admin user can deleted article', function () {
    //     $article = Article::factory()->create(['submitted_at' => now()]);

    //     Livewire::test(ArticleResource\Pages\ListArticles::class)
    //         ->callTableAction('delete', $article);
    //         //->callAction(DeleteAction::class);

    //     expect(Article::find($article->id))
    //         ->toBe(null);
    // });
})->group('articles');
