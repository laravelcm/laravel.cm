<?php

declare(strict_types=1);

use App\Livewire\Modals\ConvertDiscussion;
use App\Models\Discussion;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(ConvertDiscussion::class, function (): void {
    it('requires authorization for user to convert discussion', function (): void {
        $user = User::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $user->id]);

        Livewire::test(ConvertDiscussion::class)
            ->set('discussionId', $discussion->id)
            ->call('save')
            ->assertForbidden();
    });

    it('throws exception for non-existent discussion', function (): void {
        Livewire::test(ConvertDiscussion::class)
            ->set('discussionId', 9)
            ->call('save');
    })->throws(Illuminate\Database\Eloquent\ModelNotFoundException::class);
});
