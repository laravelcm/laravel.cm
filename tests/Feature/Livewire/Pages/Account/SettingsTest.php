<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Settings;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Settings::class, ['subscriptions' => $this->login()->subscriptions()])
        ->assertStatus(200);
});
