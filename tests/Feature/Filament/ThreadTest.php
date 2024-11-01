<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Filament\Resources\ThreadResource;
use App\Filament\Resources\ThreadResource\Pages\ListThreads;
use App\Models\Channel;
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
        Livewire::test(ThreadResource\Pages\ListThreads::class)
            ->assertCanSeeTableRecords($this->threads);
    });
})->group('threads');
