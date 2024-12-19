<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Forum;

use App\Actions\Forum\UpdateThreadAction;
use App\Events\ThreadWasCreated;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

beforeEach(function (): void {
    $this->user = $this->login();

    Event::fake();
    Notification::fake();
});

it('user can edit a thread', function (): void {
    $thread = Thread::factory()->create(['user_id' => $this->user->id]);
    $channels = Channel::factory()->count(3)->create();

    $thread->channels()->attach($channels->modelKeys());

    $thread = app(UpdateThreadAction::class)->execute([
        'title' => 'update thread title',
    ], $thread);

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->title)
        ->toBe('update thread title');

    Event::assertNotDispatched(ThreadWasCreated::class);

});
