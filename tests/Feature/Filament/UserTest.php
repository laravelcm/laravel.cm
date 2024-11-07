<?php

declare(strict_types=1);

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->users = User::factory()
        ->count(5)
        ->create();
});

describe(UserResource::class, function (): void {

    it('page can display table with records', function (): void {
        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($this->users);
    });
})->group('users');
