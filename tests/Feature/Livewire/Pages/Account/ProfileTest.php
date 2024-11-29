<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Profile;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Profile::class)
        ->assertStatus(200);
});
