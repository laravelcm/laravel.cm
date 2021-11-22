<?php

use App\Models\Activity;
use App\Models\Discussion;
use App\Models\Tag;

it('can find by slug', function () {
    Discussion::factory()->create(['slug' => 'foo']);

    expect(Discussion::findBySlug('foo'))->toBeInstanceOf(Discussion::class);
});

it('can give an excerpt of its body', function () {
    $discussion = Discussion::factory()->make(['body' => 'This is a pretty long text.']);

    expect($discussion->excerpt(7))->toEqual('This is...');
});

test('html in excerpts is html encoded', function () {
    $discussion = Discussion::factory()->make(['body' => '<p>Discussion body</p>']);

    expect($discussion->excerpt())->toEqual("&lt;p&gt;Discussion body&lt;/p&gt;\n");
});

it('can have many tags', function () {
    $tags = Tag::factory()->count(3)->create();
    $discussion = Discussion::factory()->create();
    $discussion->syncTags($tags->modelKeys());

    expect($discussion->tags->count())->toEqual(3);
});

it('records activity when a discussion is created', function () {
    actingAs();

    $discussion = Discussion::factory()->create(['user_id' => auth()->id()]);

    $this->assertDatabaseHas('activities', [
        'type' => 'created_discussion',
        'user_id' => auth()->id(),
        'subject_id' => $discussion->id,
        'subject_type' => 'discussion',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $discussion->id);

    $this->assertEquals(auth()->user()->activities->count(), 1);
});

it('generates a slug when valid url characters provided', function () {
    $discussion = Discussion::factory()->make(['slug' => 'Help with eloquent']);

    expect($discussion->slug())->toEqual('help-with-eloquent');
});

it('generates a unique slug when valid url characters provided', function () {
    $discussionOne = Discussion::factory()->create(['slug' => 'Help with eloquent']);
    $discussionTwo = Discussion::factory()->create(['slug' => 'Help with eloquent']);

    expect($discussionTwo->slug())->toEqual('help-with-eloquent-1');
});

it('generates a slug when invalid url characters provided', function () {
    $discussion = Discussion::factory()->make(['slug' => '한글 테스트']);

    // When providing a slug with invalid url characters, a random 5 character string is returned.
    expect($discussion->slug())->toMatch('/\w{5}/');
});
