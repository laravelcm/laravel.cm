<?php

declare(strict_types=1);

use App\Livewire\Pages\Forum\DetailThread;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(DetailThread::class)
        ->assertStatus(200);
});
