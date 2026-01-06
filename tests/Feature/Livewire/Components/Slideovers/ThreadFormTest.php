<?php

declare(strict_types=1);

use App\Events\ThreadWasCreated;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Components\Slideovers\ThreadForm;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\PostThreadToTelegram;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    Notification::fake();
});

describe(ThreadForm::class, function (): void {
    it('return redirect to unauthenticated user', function (): void {
        Livewire::test(ThreadForm::class)
            ->assertStatus(302);
    });

    it('render the component when authenticated user', function (): void {
        $this->login();

        Livewire::test(ThreadForm::class)
            ->assertSuccessful();
    });

    it('validate forms input', function (): void {
        $this->login();

        Livewire::test(ThreadForm::class)
            ->set('form.title', '')
            ->set('form.body', '')
            ->set('form.channels', [])
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.body' => 'required',
                'form.channels' => 'required',
            ]);
    });

    it('validate channels can extends 3 when create a thread', function (): void {
        $this->login();
        $channels = Channel::query()->take(4)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save')
            ->assertHasErrors([
                'form.channels' => 'max',
            ]);
    });

    it('user can create a new thread', function (): void {
        $user = $this->login();
        $channels = Channel::query()->take(3)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save')
            ->assertHasNoErrors();

        $thread = Thread::query()->first();
        $user->refresh();

        expect($thread?->user)->toBeInstanceOf(User::class)
            ->and($thread?->user->is($user))
            ->toBeTrue()
            ->and($user->getPoints())
            ->toBe(55);
    });

    it('user cannot create thread with and unverified email address', function (): void {
        $user = $this->createUser(['email_verified_at' => null]);
        $channels = Channel::query()->take(2)->get();

        $this->actingAs($user);

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        expect(Thread::query()->first())
            ->toBeNull();
    })->throws(UnverifiedUserException::class);

    it('user cannot updated a thread that is not author', function (): void {
        $this->login();

        $author = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $author->id]);
        $channels = Channel::query()->take(3)->get();

        $thread->channels()->attach($channels->modelKeys());

        Livewire::test(ThreadForm::class, ['threadId' => $thread->id])
            ->set('form.title', 'Updated thread question')
            ->set('form.body', 'this is my kind body updated')
            ->call('save')
            ->assertStatus(403);
    });

    it('dispatches thread created event when creating a new thread', function (): void {
        Event::fake();

        $this->login();
        $channels = Channel::query()->take(3)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing events')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        Event::assertDispatched(ThreadWasCreated::class);
    });

    it('sends telegram notification when thread is created', function (): void {
        $this->login();
        $channels = Channel::query()->take(3)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing notifications')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        $thread = Thread::query()->latest()->first();

        Notification::assertSentTo($thread, PostThreadToTelegram::class);
    });

    it('automatically subscribes author to thread', function (): void {
        $user = $this->login();
        $channels = Channel::query()->take(3)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing subscription')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        $thread = Thread::query()->latest()->first();

        expect($thread->subscribes()->where('user_id', $user->id)->exists())
            ->toBeTrue();
    });

    it('syncs channels when creating a thread', function (): void {
        $this->login();
        $channels = Channel::query()->take(3)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing channels sync')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        $thread = Thread::query()->latest()->first();

        expect($thread->channels()->count())->toBe(3)
            ->and($thread->channels->pluck('id')->toArray())
            ->toEqual($channels->pluck('id')->toArray());
    });

    it('user can update their own thread', function (): void {
        $user = $this->login();
        $channels = Channel::query()->take(2)->get();

        $thread = Thread::factory()->create(['user_id' => $user->id]);
        $thread->channels()->attach($channels->modelKeys());

        $newChannels = Channel::query()->skip(2)->take(2)->get();

        Livewire::test(ThreadForm::class, ['threadId' => $thread->id])
            ->set('form.title', 'Updated thread question by author')
            ->set('form.body', 'this is my updated body for testing author update')
            ->set('form.channels', $newChannels->pluck('id')->toArray())
            ->call('save')
            ->assertHasNoErrors();

        $thread->refresh();

        expect($thread->title)->toBe('Updated thread question by author')
            ->and($thread->body)->toContain('this is my updated body')
            ->and($thread->channels->pluck('id')->toArray())
            ->toEqual($newChannels->pluck('id')->toArray());
    });

    it('generates slug from title', function (): void {
        $this->login();
        $channels = Channel::query()->take(2)->get();

        Livewire::test(ThreadForm::class)
            ->set('form.title', 'How to Deploy Laravel Application')
            ->set('form.body', 'this is my kind body for testing slug generation')
            ->set('form.channels', $channels->pluck('id')->toArray())
            ->call('save');

        $thread = Thread::query()->latest()->first();

        expect($thread->slug)->toBe('how-to-deploy-laravel-application');
    });
})->group('forum', 'thread');
