<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(DatabaseMigrations::class);

it('can find by slug', function (): void {
    Thread::factory()->create(['slug' => 'foo']);

    expect(Thread::findBySlug('foo'))->toBeInstanceOf(Thread::class);
});

it('can give an excerpt of its body', function (): void {
    $thread = Thread::factory()->make(['body' => 'This is a pretty long text.']);

    expect($thread->excerpt(7))->toEqual('This is...');
});

test('html in excerpts is markdown converted', function (): void {
    $thread = Thread::factory()->make(['body' => '<p>Thread body</p>']);

    expect($thread->excerpt())->toEqual("Thread body\n");
});

it('can have many channels', function (): void {
    $channels = Channel::factory()->count(3)->create();
    $thread = Thread::factory()->create();
    $thread->channels()->attach($channels->modelKeys());

    expect($thread->channels->count())->toEqual(3);
})->skip();

it('records activity when a thread is created', function (): void {
    $user = $this->createUser();

    $thread = Thread::factory()->create(['user_id' => $user->id]);

    Activity::factory()->create([
        'type' => 'created_thread',
        'user_id' => $user->id,
        'subject_id' => $thread->id,
        'subject_type' => 'thread',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $thread->id);

    $this->assertEquals($user->activities->count(), 1);
})->skip();

test('its conversation is old when the oldest reply was six months ago', function (): void {
    $thread = Thread::factory()->create();
    $thread->replies()->save(Reply::factory()->make(['created_at' => now()->subMonths(7)]));

    expect($thread->isConversationOld())->toBeTrue();

    $thread = Thread::factory()->create();
    $thread->replies()->save(Reply::factory()->make());

    expect($thread->isConversationOld())->toBeFalse();
});

test('its conversation is old when there are no replies but the creation date was six months ago', function (): void {
    $thread = Thread::factory()->create(['created_at' => now()->subMonths(7)]);

    expect($thread->isConversationOld())->toBeTrue();

    $thread = Thread::factory()->create();

    expect($thread->isConversationOld())->toBeFalse();
});

test('we can mark and unmark a reply as the solution', function (): void {
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id]);
    $user = $this->createUser();

    expect($thread->isSolutionReply($reply))->toBeFalse();
    expect($thread->fresh()->wasResolvedBy($user))->toBeFalse();

    $thread->markSolution($reply, $user);

    expect($thread->isSolutionReply($reply))->toBeTrue();
    expect($thread->wasResolvedBy($user))->toBeTrue();

    $thread->unmarkSolution();

    expect($thread->isSolutionReply($reply))->toBeFalse();
    expect($thread->fresh()->wasResolvedBy($user))->toBeFalse();
});

it('can retrieve the latest threads in a correct order', function (): void {
    $threadUpdatedYesterday = createThreadFromYesterday();
    $threadFromToday = createThreadFromToday();
    $threadFromTwoDaysAgo = createThreadFromTwoDaysAgo();

    $threads = Thread::feedQuery()->limit(10)->get();

    $this->assertTrue($threadFromToday->is($threads->first()), 'First thread is incorrect');
    $this->assertTrue($threadUpdatedYesterday->is($threads->slice(1)->first()), 'Second thread is incorrect');
    $this->assertTrue($threadFromTwoDaysAgo->is($threads->last()), 'Last thread is incorrect');
});

it('can retrieve only resolved threads', function (): void {
    createThreadFromToday();
    $resolvedThread = createResolvedThread();

    $threads = Thread::resolved()->get();

    expect($threads)->toHaveCount(1);
    expect($resolvedThread->is($threads->first()))->toBeTrue();
});

it('can retrieve only active threads', function (): void {
    createThreadFromToday();
    $activeThread = createActiveThread();

    $threads = Thread::feedQuery()->active()->get();

    expect($threads)->toHaveCount(1);
    expect($activeThread->is($threads->first()))->toBeTrue();
});

it('generates a slug when valid url characters provided', function (): void {
    $thread = Thread::factory()->make(['slug' => 'Help with eloquent']);

    expect($thread->slug())->toEqual('help-with-eloquent');
});

it('generates a unique slug when valid url characters provided', function (): void {
    $threadOne = Thread::factory()->create(['slug' => 'Help with eloquent']);
    $threadTwo = Thread::factory()->create(['slug' => 'Help with eloquent']);

    expect($threadTwo->slug())->toEqual('help-with-eloquent-1');
});

it('generates a slug when invalid url characters provided', function (): void {
    $thread = Thread::factory()->make(['slug' => '한글 테스트']);

    // When providing a slug with invalid url characters, a random 5 character string is returned.
    expect($thread->slug())->toMatch('/\w{5}/');
});

// Helpers
function createThreadFromToday(): Thread
{
    $today = Carbon::now();

    return Thread::factory()->create(['created_at' => $today]);
}

function createThreadFromYesterday(): Thread
{
    $yesterday = Carbon::yesterday();

    return Thread::factory()->create(['created_at' => $yesterday]);
}

function createThreadFromTwoDaysAgo(): Thread
{
    $twoDaysAgo = Carbon::now()->subDays(2);

    return Thread::factory()->create(['created_at' => $twoDaysAgo]);
}

function createResolvedThread(): Thread
{
    $thread = createThreadFromToday();
    $reply = Reply::factory()->create();
    $user = User::factory()->create();
    $thread->markSolution($reply, $user);

    return $thread;
}

function createActiveThread(): Thread
{
    $thread = createThreadFromToday();
    $reply = Reply::factory()->create();
    $reply->to($thread);
    $reply->save();

    return $thread;
}
