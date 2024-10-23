<?php

declare(strict_types=1);

use App\Livewire\Components\Slideovers\ThreadForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ThreadForm::class)
        ->assertStatus(200);
});
