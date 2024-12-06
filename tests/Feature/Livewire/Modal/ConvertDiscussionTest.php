<?php

declare(strict_types=1);

use App\Livewire\Modals\ConvertDiscussion;
use App\Models\Discussion;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $user = User::factory()->create();
    $this->user = $this->actingAs($user);
    $this->discussion = Discussion::factory()->create();
});

describe(ConvertDiscussion::class, function (): void {
    it('requires authorization to convert discussion', function (): void {
        Livewire::test(ConvertDiscussion::class)
            ->set('discussionId', $this->discussion->id)
            ->call('save')
            ->assertForbidden();
    });

    it('throws exception for non-existent discussion', function (): void {
        Livewire::test(ConvertDiscussion::class)
            ->set('discussionId', 9)
            ->call('save');
    })->throws(Illuminate\Database\Eloquent\ModelNotFoundException::class);
});
