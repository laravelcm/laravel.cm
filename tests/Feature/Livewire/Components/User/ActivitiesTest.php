<?php

declare(strict_types=1);

use App\Livewire\Components\User\Activities;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Activities::class)
        ->assertStatus(200);
});
