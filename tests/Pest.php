<?php

declare(strict_types=1);

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

uses(Tests\TestCase::class, RefreshDatabase::class)
    ->in('Feature', '../app-modules/*/tests');

/**
 * @return Thread|Collection<int, Thread>
 */
function createThreadFromToday(int $count = 1): Thread|Collection
{
    $today = Date::now();

    if ($count === 1) {
        return Thread::factory()->create(['created_at' => $today]);
    }

    return Thread::factory()
        ->count($count)
        ->create(['created_at' => $today]);
}

function createThreadFromYesterday(): Thread
{
    $yesterday = Date::yesterday();

    return Thread::factory()->create(['created_at' => $yesterday]);
}

function createThreadFromTwoDaysAgo(): Thread
{
    $twoDaysAgo = Date::now()->subDays(2);

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
