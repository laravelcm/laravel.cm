<?php

declare(strict_types=1);

use App\Livewire\Components\User\Subscription;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Subscription::class)
        ->assertStatus(200);
});
