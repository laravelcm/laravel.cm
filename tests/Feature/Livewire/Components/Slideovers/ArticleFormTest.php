<?php

declare(strict_types=1);

use App\Livewire\Components\Slideovers\ArticleForm;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    Notification::fake();
});

it('return redirect to unauthenticated user', function (): void {
    Livewire::test(ArticleForm::class)
        ->assertStatus(302);
})->group('articles');
