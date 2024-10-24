<?php

declare(strict_types=1);

use App\Livewire\Components\ChannelsSelector;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(ChannelsSelector::class)
        ->assertStatus(200);
});
