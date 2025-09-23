<?php

declare(strict_types=1);

use App\Gamify\Points\ThreadCreated;
use App\Livewire\Components\Forum\ReplyForm;
use App\Livewire\Pages\Forum\DetailThread;
use App\Models\Thread;
use Livewire\Livewire;

describe(DetailThread::class, function (): void {
    it('renders thread successfully', function (): void {
        $thread = Thread::factory()->create();

        Livewire::test(DetailThread::class, ['thread' => $thread])
            ->assertStatus(200);
    });

    it('user can delete his own thread', function (): void {
        $user = $this->login();
        $thread = Thread::factory(['user_id' => $user->id])->create();

        givePoint(new ThreadCreated($thread));

        Livewire::test(DetailThread::class, ['thread' => $thread])
            ->callAction('delete')
            ->assertStatus(200)
            ->assertRedirect(route('forum.index'));

        $user->refresh();

        expect($user->getPoints())
            ->toBe(0);

        $this->assertModelMissing($thread);
    });

    it('user cannot delete a thread of another user', function (): void {
        $user = $this->createUser(['email' => 'john@doe.cm']);
        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->login();

        Livewire::test(DetailThread::class, ['thread' => $thread])
            ->assertActionHidden('delete');
    });

    it('can view the reply form when logged', function (): void {
        $this->login();

        $thread = Thread::factory()->create();

        Livewire::test(DetailThread::class, ['thread' => $thread])
            ->assertSee(__('pages/forum.answer_reply'));

        Livewire::test(ReplyForm::class, ['thread' => $thread])
            ->assertSuccessful();
    });

    it('user can reply to thread', function (): void {
        $user = $this->login();
        $thread = Thread::factory()->create();

        Livewire::test(ReplyForm::class, ['thread' => $thread])
            ->set('body', 'This is a reply body')
            ->call('createReply');

        expect($thread->replies->count())
            ->toBe(1)
            ->and($thread->replies->first()->user->id)
            ->toBe($user->id);
    })->skip();
});
