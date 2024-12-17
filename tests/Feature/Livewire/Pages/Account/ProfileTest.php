<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Profile;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Profile::class, ['user' => $this->login()])
        ->assertStatus(200);
});
