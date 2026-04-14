<?php

declare(strict_types=1);

use App\Filament\Cpanel\Resources\Articles\Pages\ListArticles;
use App\Models\Article;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function (): void {
    Filament::setCurrentPanel('cpanel');

    $this->user = $this->login(['email' => 'joe@laravel.cm']);
    $this->user->assignRole('admin');
});

describe('Article Sponsoring', function (): void {
    it('can sponsor a published article', function (): void {
        $article = Article::factory()->approved()->create([
            'published_at' => now()->subDay(),
        ]);

        Livewire::test(ListArticles::class)
            ->callAction(TestAction::make('sponsor')->table($article));

        $article->refresh();

        expect($article->is_sponsored)->toBeTrue()
            ->and($article->sponsored_at)->not->toBeNull();
    });

    it('can unsponsor a sponsored article', function (): void {
        $article = Article::factory()->approved()->create([
            'published_at' => now()->subDay(),
            'is_sponsored' => true,
            'sponsored_at' => now()->subWeek(),
        ]);

        Livewire::test(ListArticles::class)
            ->callAction(TestAction::make('unsponsor')->table($article));

        $article->refresh();

        expect($article->is_sponsored)->toBeFalse()
            ->and($article->sponsored_at)->not->toBeNull();
    });

    it('preserves sponsored_at date when re-sponsoring', function (): void {
        $originalDate = now()->subMonth();

        $article = Article::factory()->approved()->create([
            'published_at' => now()->subDay(),
            'is_sponsored' => false,
            'sponsored_at' => $originalDate,
        ]);

        Livewire::test(ListArticles::class)
            ->callAction(TestAction::make('sponsor')->table($article));

        $article->refresh();

        expect($article->is_sponsored)->toBeTrue()
            ->and($article->sponsored_at->format('Y-m-d'))->toBe($originalDate->format('Y-m-d'));
    });

    it('hides sponsor action for non-published articles', function (): void {
        $article = Article::factory()->submitted()->create();

        Livewire::test(ListArticles::class)
            ->assertActionHidden(TestAction::make('sponsor')->table($article));
    });

    it('prevents non-admin users from accessing the resource', function (): void {
        $regularUser = User::factory()->create(['email_verified_at' => now()]);
        $this->be($regularUser);

        Livewire::test(ListArticles::class)
            ->assertForbidden();
    });
})->group('articles', 'sponsoring');
