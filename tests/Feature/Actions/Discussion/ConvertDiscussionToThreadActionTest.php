<?php

declare(strict_types=1);

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Enums\UserRole;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Support\Facades\Notification;

beforeEach(function (): void {
    Notification::fake();

    $this->user = $this->login();
    $this->discussion = Discussion::factory()->create(['user_id' => $this->user->id]);
});

describe(ConvertDiscussionToThreadAction::class, function (): void {
    it('allows discussion author to convert his discussion to a forum topic', function (): void {
        $replies = Reply::factory()->count(3)->create([
            'replyable_type' => 'discussion',
            'replyable_id' => $this->discussion->id,
        ]);

        $thread = resolve(ConvertDiscussionToThreadAction::class)->execute(discussion: $this->discussion);

        expect($thread)->toBeInstanceOf(Thread::class)
            ->and(Discussion::query()->find($this->discussion->id))
            ->toBeNull();

        $replies->each(function ($reply) use ($thread): void {
            $updatedReply = Reply::query()->find($reply->id);

            expect($updatedReply->replyable_type)
                ->toBe('thread')
                ->and($updatedReply->replyable_id)
                ->toBe($thread->id);
        });

        Notification::assertCount(3);
    });

    it('allows admin users to convert any discussion to a forum topic', function (): void {
        $this->user->assignRole(UserRole::Admin->value);

        Reply::factory()->count(3)->create([
            'replyable_type' => 'discussion',
            'replyable_id' => $this->discussion->id,
        ]);

        $thread = resolve(ConvertDiscussionToThreadAction::class)->execute(discussion: $this->discussion);

        expect($thread)->toBeInstanceOf(Thread::class);

        Notification::assertCount(4);
    });
});
