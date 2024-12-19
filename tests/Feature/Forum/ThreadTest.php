<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;

it('can find by slug', function (): void {
    Thread::factory()->create(['slug' => 'foo']);

    expect(Thread::findBySlug('foo'))->toBeInstanceOf(Thread::class);
});

it('can give an excerpt of its body', function (): void {
    /** @var Thread $thread */
    $thread = Thread::factory()->make(['body' => 'This is a pretty long text.']);

    expect($thread->excerpt(7))->toEqual('This is...');
});

test('html in excerpts is markdown converted', function (): void {
    /** @var Thread $thread */
    $thread = Thread::factory()->make(['body' => 'Thread body']);

    expect($thread->excerpt())->toEqual("Thread body\n");
});

it('can have many channels', function (): void {
    /** @var Thread $thread */
    $thread = Thread::factory()->create();
    $channels = Channel::factory()->count(3)->create();

    $thread->channels()->attach($channels->modelKeys());

    expect($thread->channels->count())->toEqual(3);
});

it('records activity when a thread is created', function (): void {
    $user = $this->login();

    Thread::factory()->create(['user_id' => $user->id]);
    $activity = Activity::query()->first();

    expect($activity->subject)
        ->toBeInstanceOf(Thread::class)
        ->and($activity->type)
        ->toEqual('created_thread')
        ->and($user->activities->count())
        ->toEqual(1);
});

test('its conversation is old when the oldest reply was six months ago', function (): void {
    /** @var Thread $thread */
    $thread = Thread::factory()->create();
    $thread->replies()->save(Reply::factory()->make(['created_at' => now()->subMonths(7)]));

    expect($thread->isConversationOld())->toBeTrue();

    /** @var Thread $newThread */
    $newThread = Thread::factory()->create();
    $newThread->replies()->save(Reply::factory()->make());

    expect($newThread->isConversationOld())->toBeFalse();
});

test('its conversation is old when there are no replies but the creation date was six months ago', function (): void {
    /** @var Thread $thread */
    $thread = Thread::factory()->create(['created_at' => now()->subMonths(7)]);

    expect($thread->isConversationOld())->toBeTrue();

    /** @var Thread $anotherThread */
    $anotherThread = Thread::factory()->create();

    expect($anotherThread->isConversationOld())->toBeFalse();
});

test('we can mark and unmark a reply as the solution', function (): void {
    $user = $this->createUser();

    /** @var Thread $thread */
    $thread = Thread::factory()->create();
    /** @var Reply $reply */
    $reply = Reply::factory()->create(['replyable_id' => $thread->id]);

    expect($thread->isSolutionReply($reply))
        ->toBeFalse()
        ->and($thread->fresh()?->wasResolvedBy($user))
        ->toBeFalse();

    $thread->markSolution($reply, $user);

    expect($thread->isSolutionReply($reply))
        ->toBeTrue()
        ->and($thread->wasResolvedBy($user))
        ->toBeTrue();

    $thread->unmarkSolution();

    expect($thread->isSolutionReply($reply))
        ->toBeFalse()
        ->and($thread->fresh()?->wasResolvedBy($user))
        ->toBeFalse();
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
    /** @var Thread $resolvedThread */
    $resolvedThread = createResolvedThread();

    $threads = Thread::query()->scopes('resolved')->get();

    expect($threads)
        ->toHaveCount(1)
        ->and($resolvedThread->is($threads->first()))
        ->toBeTrue();
});

it('can retrieve only active threads', function (): void {
    createThreadFromToday();
    $activeThread = createActiveThread();

    $threads = Thread::feedQuery()->active()->get();

    expect($threads)
        ->toHaveCount(1)
        ->and($activeThread->is($threads->first()))
        ->toBeTrue();
});

it('generates a slug when valid url characters provided', function (): void {
    $thread = Thread::factory()->make(['slug' => 'Help with eloquent']);

    expect($thread->slug)->toEqual('help-with-eloquent');
});

it('generates a unique slug when valid url characters provided', function (): void {
    Thread::factory()->create(['slug' => 'Help with eloquent']);
    $thread = Thread::factory()->create(['slug' => 'Help with eloquent']);

    expect($thread->slug)->toEqual('help-with-eloquent-1');
});

it('generates a slug when invalid url characters provided', function (): void {
    $thread = Thread::factory()->make(['slug' => '한글 테스트']);

    // When providing a slug with invalid url characters, a random 5 character string is returned.
    expect($thread->slug)->toMatch('/\w{5}/');
});
