<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

it('records activity when an article is created', function (): void {
    $user = $this->login();

    $article = Article::factory(['user_id' => $user->id])->create();
    $activity = Activity::query()->first();

    expect($activity->subject->id)
        ->toEqual($article->id)
        ->and(Activity::query()->count())
        ->toEqual(1);
});

it('get feed from any user', function (): void {
    $user = $this->login();

    Article::factory(['user_id' => $user->id])
        ->count(2)
        ->create();

    $user->activities()
        ->first()
        ->update(['created_at' => Carbon::now()->subWeek()]);

    $feed = Activity::feed($user);

    $this->assertTrue($feed->keys()->contains(
        Carbon::now()->format('Y-m-d')
    ));

    $this->assertFalse($feed->keys()->contains(
        Carbon::now()->subWeek()->format('Y-m-d')
    ));
});

it('does not update the last activity for unauthenticated users', function (): void {
    Route::middleware(\App\Http\Middleware\TrackLastActivity::class)
        ->get('/activity-user', fn () => 'ok');

    $this->get('/activity-user')->assertOk();

    $this->assertDatabaseMissing('users', ['last_active_at' => now()]);
});
