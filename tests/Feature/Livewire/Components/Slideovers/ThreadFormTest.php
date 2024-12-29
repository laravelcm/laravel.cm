<?php

declare(strict_types=1);

use App\Exceptions\UnverifiedUserException;
use App\Livewire\Components\Slideovers\ThreadForm;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    Notification::fake();
});

/**
 * @var \Tests\TestCase $this
 */
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
            ->fillForm([
                'title' => '',
                'body' => '',
                'channels' => [],
            ])
            ->call('save')
            ->assertHasFormErrors([
                'title' => ['required'],
                'body' => ['required'],
            ]);
    });

    it('validate channels can extends 3 when create a thread', function (): void {
        $this->login();

        Livewire::test(ThreadForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'channels' => ['laravel', 'php', 'tailwind', 'gaming'],
            ])
            ->call('save')
            ->assertHasFormErrors([
                'channels' => ['max'],
            ]);
    });

    it('user can create a new thread', function (): void {
        $user = $this->login();
        $channels = Channel::factory()->count(3)->create();

        Livewire::test(ThreadForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'channels' => $channels->pluck('id')->toArray(),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

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
        $channels = Channel::factory()->count(2)->create();

        $this->actingAs($user);

        Livewire::test(ThreadForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'channels' => $channels->pluck('id')->toArray(),
            ])
            ->call('save');

        expect(Thread::query()->first())
            ->toBeNull();
    })->expectException(UnverifiedUserException::class);

    it('user cannot updated a thread that is not author', function (): void {
        $this->login();

        $author = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $author->id]);
        $channels = Channel::factory()->count(3)->create();

        $thread->channels()->attach($channels->modelKeys());

        Livewire::test(ThreadForm::class, ['threadId' => $thread->id])
            ->fillForm([
                'title' => 'Updated thread question',
                'body' => 'this is my kind body updated',
            ])
            ->call('save')
            ->assertStatus(403);
    });
})->group('thread');
