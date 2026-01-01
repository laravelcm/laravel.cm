<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Index;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $this->login();

    Livewire::test(Index::class)
        ->assertStatus(200);
});
