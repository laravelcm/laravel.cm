<?php

declare(strict_types=1);

use App\Filament\Resources\DiscussionResource;
use App\Filament\Resources\DiscussionResource\Pages\ListDiscussions;
use App\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->discussions = Discussion::factory()
        ->count(10)
        ->state(new Sequence(
            ['is_pinned' => true, 'locked' => false],
            ['is_pinned' => false, 'locked' => true],
        ))
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
            ->assertCountTableRecords(5);
    });

    it('admin user can filter discussion by `locked`', function (): void {
        Livewire::test(ListDiscussions::class)
            ->assertCanSeeTableRecords($this->discussions)
            ->filterTable('is_locked')
            ->assertCountTableRecords(5);
    });
})->group('discussions');
