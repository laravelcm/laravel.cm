<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Forum;

use App\Actions\Forum\CreateOrUpdateThreadAction;
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

it('user can create a thread', function (): void {
    $channels = Channel::factory()->count(2)->create();

    $thread = app(createOrUpdateThreadAction::class)->execute([
        'title' => 'thread title',
        'slug' => 'thread-title',
        'user_id' => $this->user->id,
        'body' => 'This is a test action thread for created or updated thread.',
        'channels' => [$channels->first(), $channels->last()],
    ]);

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->user_id)
        ->toBe($this->user->id);

    Event::assertDispatched(ThreadWasCreated::class);
});

it('user can edit a thread', function (): void {
    $thread = Thread::factory()->create(['user_id' => $this->user->id]);
    $channels = Channel::factory()->count(3)->create();

    $thread->channels()->attach($channels->modelKeys());

    $thread = app(createOrUpdateThreadAction::class)->execute([
        'title' => 'update thread title',
    ], $thread->id);

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->title)
        ->toBe('update thread title');

    Event::assertNotDispatched(ThreadWasCreated::class);

});
