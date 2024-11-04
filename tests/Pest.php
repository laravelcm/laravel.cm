<?php

declare(strict_types=1);

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

uses(Tests\TestCase::class, RefreshDatabase::class)
    ->in('Feature');

function createThreadFromToday(int $count = 1): Thread|Collection
{
    $today = Carbon::now();

    if ($count === 1) {
        return Thread::factory()->create(['created_at' => $today]);
    }

    return Thread::factory()
        ->count($count)
        ->create(['created_at' => $today]);
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
    /** @var Thread $thread */
    $thread = createThreadFromToday();
    $reply = Reply::factory()->create();
    $reply->to($thread);
    $reply->save();

    return $thread;
}
