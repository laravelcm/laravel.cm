<?php

declare(strict_types=1);

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;

beforeEach(function (): void {
    $this->discussion = Discussion::factory()->create();
});

describe(ConvertDiscussionToThreadAction::class, function (): void {
    it('can converts a discussion to a thread', function (): void {
        $replies = Reply::factory()->count(3)->create([
            'replyable_type' => 'discussion',
            'replyable_id' => $this->discussion->id,
        ]);

        $thread = app(ConvertDiscussionToThreadAction::class)->execute(discussion: $this->discussion);

        expect($thread)->toBeInstanceOf(Thread::class)
            ->and(Discussion::find($this->discussion->id))->toBeNull();

        $replies->each(function ($reply) use ($thread): void {
            $updatedReply = Reply::find($reply->id);

            expect($updatedReply->replyable_type)->toBe('thread')
                ->and($updatedReply->replyable_id)->toBe($thread->id);
        });
    });

    it('can handles admin conversion', function (): void {
        $thread = app(ConvertDiscussionToThreadAction::class)->execute(discussion: $this->discussion, isAdmin: true);

        expect($thread)->toBeInstanceOf(Thread::class);
    });
});
