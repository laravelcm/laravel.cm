<?php

declare(strict_types=1);

use App\Livewire\Pages\Forum\Index;
use App\Models\Thread;
use Livewire\Livewire;
use  Illuminate\Support\Facades\App;

use function Pest\Laravel\get;

it('forum page renders successfully', function (): void {
    get(route('forum.index'))->assertOk();

    Livewire::test(Index::class)
        ->assertStatus(200);
})->group('forum');

it('forum page renders views with threads', function (): void {
    get(route('forum.index'))->assertOk();

    Thread::factory()->count(50)->create(['locale' => 'fr']);
    App::setLocale('fr');

    Livewire::test(Index::class)
        ->assertViewHas('threads', fn ($threads) => count($threads) === 30)
        ->assertSee(__('pagination.next'))
        ->assertStatus(200);
});
