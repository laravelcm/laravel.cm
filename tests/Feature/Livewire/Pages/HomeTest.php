<?php

declare(strict_types=1);

use App\Livewire\Pages\Home;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

describe(Home::class, function (): void {
    it('displays sponsored articles before regular articles', function (): void {
        Cache::tags(['home', 'articles'])->flush();

        $regularArticle = Article::factory()->approved()->create([
            'title' => 'Regular Article',
            'published_at' => now(),
            'is_sponsored' => false,
        ]);

        $sponsoredArticle = Article::factory()->approved()->create([
            'title' => 'Sponsored Article',
            'published_at' => now()->subWeek(),
            'is_sponsored' => true,
            'sponsored_at' => now()->subWeek(),
        ]);

        Livewire::test(Home::class)
            ->assertSeeInOrder(['Sponsored Article', 'Regular Article']);
    });
})->group('home');
