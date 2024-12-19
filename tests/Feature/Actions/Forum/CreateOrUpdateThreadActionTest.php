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
    $channelOne = Channel::factory()->create(['name' => 'channel 1', 'slug' => 'channel-1']);
    $channelTwo = Channel::factory()->create(['name' => 'channel 2', 'slug' => 'channel-2']);
    $threadData = [
        'title' => 'thread title',
        'slug' => 'thread-title',
        'user_id' => $this->user->id,
        'body' => 'This is a test action thread for created or updated thread.',
        'channels' => [$channelOne->id, $channelTwo->id],
    ];

    $thread = app(createOrUpdateThreadAction::class)->execute($threadData);

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

    $threadData = [
        'title' => 'update thread title',
    ];

    $thread = app(createOrUpdateThreadAction::class)->execute($threadData, $thread);

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->title)
        ->toBe('update thread title');

    Event::assertNotDispatched(ThreadWasCreated::class);

});
