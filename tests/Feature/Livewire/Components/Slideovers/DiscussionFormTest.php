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
        $tags = Tag::factory()->count(3)->create([
            'concerns' => ['discussion'],
        ]);

        Livewire::test(DiscussionForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing discussions')
            ->set('form.tags', $tags->pluck('id')->toArray())
            ->call('save')
            ->assertHasNoErrors();

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
            ->set('form.title', '')
            ->set('form.body', '')
            ->set('form.tags', [])
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'required',
                'form.body' => 'required',
                'form.tags' => 'required',
            ]);
    });

    it('validate tags cannot exceed 3 when create a discussion', function (): void {
        $this->login();
        $tags = Tag::factory()->count(4)->create([
            'concerns' => ['discussion'],
        ]);

        Livewire::test(DiscussionForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing max tags validation')
            ->set('form.tags', $tags->pluck('id')->toArray())
            ->call('save')
            ->assertHasErrors([
                'form.tags' => 'max',
            ]);
    });

    it('user cannot create discussion with an unverified email address', function (): void {
        $user = $this->createUser(['email_verified_at' => null]);
        $tags = Tag::factory()->count(2)->create([
            'concerns' => ['discussion'],
        ]);

        $this->actingAs($user);

        Livewire::test(DiscussionForm::class)
            ->set('form.title', 'I have a question about laravel Cameroun')
            ->set('form.body', 'this is my kind body for testing unverified user')
            ->set('form.tags', $tags->pluck('id')->toArray())
            ->call('save');

        expect(Discussion::query()->first())
            ->toBeNull();
    })->throws(UnverifiedUserException::class);

    it('validate minimum title length', function (): void {
        $this->login();
        $tags = Tag::factory()->count(2)->create([
            'concerns' => ['discussion'],
        ]);

        Livewire::test(DiscussionForm::class)
            ->set('form.title', 'Short')
            ->set('form.body', 'this is my kind body for testing minimum title length')
            ->set('form.tags', $tags->pluck('id')->toArray())
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'min',
            ]);
    });

    it('validate minimum body length', function (): void {
        $this->login();
        $tags = Tag::factory()->count(2)->create([
            'concerns' => ['discussion'],
        ]);

        Livewire::test(DiscussionForm::class)
            ->set('form.title', 'I have a question about laravel')
            ->set('form.body', 'Short body')
            ->set('form.tags', $tags->pluck('id')->toArray())
            ->call('save')
            ->assertHasErrors([
                'form.body' => 'min',
            ]);
    });

    it('user cannot update a discussion that is not author', function (): void {
        $this->login();

        $author = User::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $author->id]);
        $tags = Tag::factory()->count(3)->create([
            'concerns' => ['discussion'],
        ]);

        $discussion->tags()->attach($tags->modelKeys());

        Livewire::test(DiscussionForm::class, ['discussionId' => $discussion->id])
            ->set('form.title', 'Updated discussion topic for testing authorization')
            ->set('form.body', 'this is my kind body updated for testing authorization')
            ->call('save')
            ->assertStatus(200);

        expect($discussion->fresh()->title)->not->toBe('Updated discussion topic for testing authorization');
    });

    it('user can update their own discussion', function (): void {
        $user = $this->login();
        $tags = Tag::factory()->count(2)->create([
            'concerns' => ['discussion'],
        ]);

        $discussion = Discussion::factory()->create(['user_id' => $user->id]);
        $discussion->tags()->attach($tags->modelKeys());

        $newTags = Tag::factory()->count(2)->create([
            'concerns' => ['discussion'],
        ]);

        Livewire::test(DiscussionForm::class, ['discussionId' => $discussion->id])
            ->set('form.title', 'Updated discussion topic by author')
            ->set('form.body', 'this is my updated body for testing author update')
            ->set('form.tags', $newTags->pluck('id')->toArray())
            ->call('save')
            ->assertHasNoErrors();

        $discussion->refresh();

        expect($discussion->title)->toBe('Updated discussion topic by author')
            ->and($discussion->body)->toContain('this is my updated body');
    });
})->group('forum', 'discussion');
