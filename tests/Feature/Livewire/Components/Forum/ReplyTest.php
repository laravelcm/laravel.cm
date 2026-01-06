<?php

declare(strict_types=1);

use App\Gamify\Points\ReplyCreated;
use App\Livewire\Components\Forum\Reply;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use Livewire\Livewire;

describe(Reply::class, function (): void {
    it('removes points from user when reply is deleted', function (): void {
        $user = $this->login();
        $thread = Thread::factory()->create();
        $reply = ReplyModel::factory()->create(['user_id' => $user->id]);
        $reply->to($thread);
        $reply->save();

        givePoint(new ReplyCreated($reply, $user));

        expect($user->fresh()->getPoints())->toBe(10);

        Livewire::test(Reply::class, ['reply' => $reply, 'thread' => $thread])
            ->call('delete')
            ->assertRedirect(route('forum.show', $thread));

        expect($user->fresh()->getPoints())->toBe(0)
            ->and(ReplyModel::query()->where('id', $reply->id)->exists())->toBeFalse();
    });

    it('can delete reply even if points were never given', function (): void {
        $user = $this->login();
        $thread = Thread::factory()->create();
        $reply = ReplyModel::factory()->create(['user_id' => $user->id]);
        $reply->to($thread);
        $reply->save();

        expect($user->fresh()->getPoints())->toBe(0);

        Livewire::test(Reply::class, ['reply' => $reply, 'thread' => $thread])
            ->call('delete')
            ->assertRedirect(route('forum.show', $thread));

        expect($user->fresh()->getPoints())->toBe(0)
            ->and(ReplyModel::query()->where('id', $reply->id)->exists())->toBeFalse();
    });

    it('only author can delete their reply', function (): void {
        $author = $this->createUser(['email' => 'author@laravel.cm']);
        $otherUser = $this->login();

        $thread = Thread::factory()->create();
        $reply = ReplyModel::factory()->create(['user_id' => $author->id]);
        $reply->to($thread);
        $reply->save();

        Livewire::test(Reply::class, ['reply' => $reply, 'thread' => $thread])
            ->call('delete');

        expect(ReplyModel::query()->where('id', $reply->id)->exists())->toBeTrue();
    });
})->group('forum', 'reply');
