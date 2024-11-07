<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Dashboard;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Dashboard::class)
        ->assertStatus(200);
});
