<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Forum;

use App\Actions\Forum\CreateThreadAction;
use App\Events\ThreadWasCreated;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

it('user can create a thread', function (): void {
    Event::fake();
    Notification::fake();

    $this->user = $this->login();

    $channels = Channel::query()->take(2)->get();

    $thread = resolve(CreateThreadAction::class)->execute([
        'title' => 'thread title',
        'slug' => 'thread-title',
        'user_id' => $this->user->id,
        'body' => 'This is a test action thread for created or updated thread.',
        'locale' => 'fr',
    ]);

    $thread->channels()->sync($channels->modelKeys());

    expect($thread)
        ->toBeInstanceOf(Thread::class)
        ->and($thread->user_id)
        ->toBe($this->user->id)
        ->and($thread->channels()->count())
        ->toBe(2);

    Event::assertDispatched(ThreadWasCreated::class);
});
