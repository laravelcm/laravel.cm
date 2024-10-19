<?php

declare(strict_types=1);

use App\Actions\Discussion\CreateDiscussionAction;
use App\Data\Discussion\CreateDiscussionData;
use App\Models\Discussion;
use App\Models\Tag;
use Illuminate\Support\Facades\Notification;

beforeEach(function (): void {
    Notification::fake();

    $this->user = $this->login();
    $this->tagOne = Tag::factory()->create(['name' => 'Tag 1', 'concerns' => ['discussion']]);
    $this->tagTwo = Tag::factory()->create(['name' => 'Tag 2', 'concerns' => ['discussion', 'post']]);
});

describe(CreateDiscussionAction::class, function (): void {
    it('return the created discussion', function (): void {
        $discussionData = CreateDiscussionData::from([
            'title' => 'Discussion title',
            'body' => 'Discussion body',
            'tags' => [],
        ]);

        $discussion = app(CreateDiscussionAction::class)->execute($discussionData);

        expect($discussion)
            ->toBeInstanceOf(Discussion::class)
            ->and($discussion->tags)
            ->toHaveCount(0)
            ->and($discussion->user_id)
            ->toBe($this->user->id);
    });

    it('return the created discussion with associate tags', function (): void {
        $discussionData = CreateDiscussionData::from([
            'title' => 'Discussion with associate tags',
            'body' => 'Discussion body for the tags',
            'tags' => [$this->tagOne->id, $this->tagTwo->id],
        ]);

        $discussion = app(CreateDiscussionAction::class)->execute($discussionData);

        expect($discussion)
            ->toBeInstanceOf(Discussion::class)
            ->and($discussion->tags)
            ->toHaveCount(2)
            ->and($discussion->user_id)
            ->toBe($this->user->id);
    });
})->group('Discussions');
