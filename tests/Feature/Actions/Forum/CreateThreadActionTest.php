<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Forum;

use App\Actions\Forum\CreateThreadAction;
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

    $thread = app(CreateThreadAction::class)->execute([
        'title' => 'thread title',
        'slug' => 'thread-title',
        'user_id' => $this->user->id,
        'body' => 'This is a test action thread for created or updated thread.',
        'channels' => [$channels->modelKeys()],
    ]);

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->user_id)
        ->toBe($this->user->id);

    Event::assertDispatched(ThreadWasCreated::class);
});
