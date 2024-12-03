<?php

declare(strict_types=1);

use App\Livewire\Components\User\Password;
use Livewire\Livewire;

describe(Password::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Password::class)
            ->assertStatus(200);
    });
});
