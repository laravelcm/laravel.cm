<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Filament\Resources\ThreadResource;
use App\Filament\Resources\ThreadResource\Pages\ListThreads;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->ActingAs($this->user);
    $this->threads = Thread::factory()->count(10)->state(
        new Sequence(
            ['locked' => false],
            ['locked' => true]
        )
    )
        ->create();
});

describe(ThreadResource::class, function (): void {

    it('page can display table with records', function (): void {
        Livewire::test(ThreadResource\Pages\ListThreads::class)
            ->assertCanSeeTableRecords($this->threads);
    });

    it('admin user can filter thread by `locked`', function (): void {
        Livewire::test(ListThreads::class)
            ->assertCanSeeTableRecords($this->threads)
            ->filterTable('is_locked')
            ->assertCountTableRecords(5);
    });

    it('can filter thread by `user_id`', function (): void {
        $authorId = $this->threads->first()->user_id;
        Livewire::test(ListThreads::class)
            ->assertCanSeeTableRecords($this->threads)
            ->filterTable('Auteur', $authorId)
            ->assertCanSeeTableRecords($this->threads->where('user_id', $authorId))
            ->assertCanNotSeeTableRecords($this->threads->where('user_id', '!=', $authorId));
    });

})->group('threads');
