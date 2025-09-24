<?php

declare(strict_types=1);

use App\Filament\Resources\Threads\ThreadResource;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->ActingAs($this->user);
    $this->threads = Thread::factory()->count(2)->state(
        new Sequence(
            ['locked' => false],
            ['locked' => true]
        )
    )
        ->create();
});

describe(ThreadResource::class, function (): void {
    it('page can display table with records', function (): void {
        Livewire::test(Threads\Pages\ListThreads::class)
            ->assertCanSeeTableRecords($this->threads);
    });
})->group('threads');
