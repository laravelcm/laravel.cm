<?php

declare(strict_types=1);

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {

    $this->user = $this->login();
});

describe(UserResource::class, function (): void {

    it('page can display table with records without admin', function (): void {

        $users = User::factory()
            ->count(5)
            ->create();

        createAndAssignRole('admin', User::first());

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->assertCountTableRecords(5);

    });

    it('page can display table with records without moderator', function (): void {

        $users = User::factory()
            ->count(3)
            ->create();

        createAndAssignRole('moderator', User::first());

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->assertCountTableRecords(3);

    });
})->group('users');
