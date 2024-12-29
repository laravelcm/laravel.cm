<?php

declare(strict_types=1);

use App\Exceptions\UnverifiedUserException;
use App\Livewire\Components\Slideovers\DiscussionForm;
use App\Models\Discussion;
use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

describe(DiscussionForm::class, function (): void {
    it('return redirect to unauthenticated user', function (): void {
        Livewire::test(DiscussionForm::class)
            ->assertStatus(302);
    });

    it('render the component when authenticated user', function (): void {
        $this->login();

        Livewire::test(DiscussionForm::class)
            ->assertSuccessful();
    });

    it('user can create a new discussion', function (): void {
        $user = $this->login();
        $tags = Tag::factory()->count(3)->create();

        Livewire::test(DiscussionForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'tags' => $tags->pluck('id')->toArray(),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $discussion = Discussion::query()->first();
        $user->refresh();

        expect($discussion?->user)->toBeInstanceOf(User::class)
            ->and($discussion?->user->is($user))
            ->toBeTrue()
            ->and($user->getPoints())
            ->toBe(20);
    });

    it('validate forms input', function (): void {
        $this->login();

        Livewire::test(DiscussionForm::class)
            ->fillForm([
                'title' => '',
                'body' => '',
                'tags' => [],
            ])
            ->call('save')
            ->assertHasFormErrors([
                'title' => ['required'],
                'body' => ['required'],
            ]);
    });

    it('validate tags can extends 3 when create a discussion', function (): void {
        $this->login();

        Livewire::test(DiscussionForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'tags' => ['alpinejs', 'php', 'tailwindcss', 'react'],
            ])
            ->call('save')
            ->assertHasFormErrors([
                'tags' => ['max'],
            ]);
    });

    it('user cannot create discussion with and unverified email address', function (): void {
        $user = $this->createUser(['email_verified_at' => null]);
        $tags = Tag::factory()->count(2)->create();

        $this->actingAs($user);

        Livewire::test(DiscussionForm::class)
            ->fillForm([
                'title' => 'I have a question about laravel DRC',
                'body' => 'this is my kind body',
                'tags' => $tags->pluck('id')->toArray(),
            ])
            ->call('save');

        expect(Discussion::query()->first())
            ->toBeNull();
    })->expectException(UnverifiedUserException::class);

    it('user cannot updated a discussion that is not author', function (): void {
        $this->login();

        $author = User::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $author->id]);
        $tags = Tag::factory()->count(3)->create();

        $discussion->tags()->attach($tags->modelKeys());

        Livewire::test(DiscussionForm::class, ['discussionId' => $discussion->id])
            ->fillForm([
                'title' => 'Updated discussion topic',
                'body' => 'this is my kind body updated',
            ])
            ->call('save')
            ->assertStatus(403);
    });
})->group('discussion');
