<?php

declare(strict_types=1);

use App\Livewire\Components\Slideovers\ArticleForm;
use Livewire\Livewire;

describe(ArticleForm::class, function (): void {
    it('return redirect to unauthenticated user', function (): void {
        Livewire::test(ArticleForm::class)
            ->assertStatus(302);
    });
})->group('articles');
