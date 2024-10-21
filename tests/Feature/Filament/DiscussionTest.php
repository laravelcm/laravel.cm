<?php

declare(strict_types=1);

use App\Filament\Resources\DiscussionResource;
use App\Filament\Resources\DiscussionResource\Pages\ListDiscussions;
use App\Models\Discussion;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->discussions = Discussion::factory()
        ->count(10)
        ->state(function () {
            return [
                'is_pinned' => rand(0, 1),
                'locked' => rand(0, 1),
                'created_at' => now(),
            ];
        })
        ->create();
});

describe(DiscussionResource::class, function (): void {

    it('page can display table with records', function (): void {
        Livewire::test(ListDiscussions::class)
            ->assertCanSeeTableRecords($this->discussions);
    });

    it('admin user can filter discussion by `is_pinned`', function (): void {

        Livewire::test(ListDiscussions::class)
            ->assertCanSeeTableRecords($this->discussions)
            ->filterTable('is_pinned')
            ->assertCanSeeTableRecords($this->discussions->where('is_pinned', true))
            ->assertCanNotSeeTableRecords($this->discussions->where('is_pinned', false));
    });

    it('admin user can filter discussion by `locked`', function (): void {

        Livewire::test(ListDiscussions::class)
            ->assertCanSeeTableRecords($this->discussions)
            ->filterTable('is_locked')
            ->assertCanSeeTableRecords($this->discussions->where('locked', true))
            ->assertCanNotSeeTableRecords($this->discussions->where('locked', false));
    });

})->group(groups: 'discussions');
