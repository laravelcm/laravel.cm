<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Discussion;
use App\Models\Tag;

it('can find by slug', function (): void {
    Discussion::factory()->create(['slug' => 'foo']);

    expect(Discussion::findBySlug('foo'))->toBeInstanceOf(Discussion::class);
});

it('can give an excerpt of its body', function (): void {
    $discussion = Discussion::factory()->make(['body' => 'This is a pretty long text.']);

    expect($discussion->excerpt(7))->toEqual('This is...');
});

test('html in excerpts is markdown converted', function (): void {
    $discussion = Discussion::factory()->make(['body' => '### A propos de moi']);

    expect($discussion->excerpt())->toEqual("#A propos de moi\n");
});

it('can have many tags', function (): void {
    $tags = Tag::factory()->count(3)->create();
    $discussion = Discussion::factory()->create();
    $discussion->syncTags($tags->modelKeys());

    expect($discussion->tags->count())->toEqual(3);
});

it('records activity when a discussion is created', function (): void {
    $user = $this->login();

    $discussion = Discussion::factory(['user_id' => $user->id])->create();

    $activity = Activity::query()->first();

    $this->assertEquals($activity->subject->id, $discussion->id);

    $this->assertEquals($user->activities->count(), 1);
});

it('generates a slug when valid url characters provided', function (): void {
    $discussion = Discussion::factory()->make(['slug' => 'Help with eloquent']);

    expect($discussion->slug())->toEqual('help-with-eloquent');
});

it('generates a unique slug when valid url characters provided', function (): void {
    $discussionOne = Discussion::factory()->create(['slug' => 'Help with eloquent']);
    $discussionTwo = Discussion::factory()->create(['slug' => 'Help with eloquent']);

    expect($discussionTwo->slug())->toEqual('help-with-eloquent-1');
});

it('generates a slug when invalid url characters provided', function (): void {
    $discussion = Discussion::factory()->make(['slug' => '한글 테스트']);

    // When providing a slug with invalid url characters, a random 5 character string is returned.
    expect($discussion->slug())->toMatch('/\w{5}/');
});
