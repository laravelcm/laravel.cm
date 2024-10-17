<?php

declare(strict_types=1);

use App\Livewire\Pages\Forum\Index;
use Livewire\Livewire;

describe(Index::class, function (): void {
    it('forum page renders successfully', function (): void {
        Livewire::test(Index::class)
            ->assertStatus(200);
    })->group('forum');
});
