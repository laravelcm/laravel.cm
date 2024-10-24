<?php

declare(strict_types=1);

use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TrackLastActiveAt;

it('records activity when an article is created', function (): void {
    $user = $this->createUser();

    $article = Article::factory()->create(['user_id' => $user->id]);

    Activity::factory()->create([
        'type' => 'created_article',
        'user_id' => $user->id,
        'subject_id' => $article->id,
        'subject_type' => 'article',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $article->id);
})->skip();

it('get feed from any user', function (): void {
    $user = $this->createUser();

    Article::factory()->count(2)->create(['user_id' => $user->id]);
    $user->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

    $feed = Activity::feed($user);

    $this->assertTrue($feed->keys()->contains(
        Carbon::now()->format('Y-m-d')
    ));

    $this->assertFalse($feed->keys()->contains(
        Carbon::now()->subWeek()->format('Y-m-d')
    ));
})->skip();

it('updates the last activity for authenticated users', function () {
    $user = User::factory()->create([
        'last_active_at' => Carbon::now()->subMinutes(10),
    ]);

    $this->actingAs($user);

    Route::middleware(TrackLastActiveAt::class)->get('/activity-user', function () {
        return 'ok';
    });

    $this->get('/activity-user')->assertOk();

    $user->refresh();

    expect($user->last_active_at->greaterThan(Carbon::now()->subMinutes(1)))->toBeTrue();
});

it('does not update the last activity for unauthenticated users', function () {
    Route::middleware(TrackLastActiveAt::class)->get('/activity-user', function () {
        return 'ok';
    });

    $this->get('/activity-user')->assertOk();

    $this->assertDatabaseMissing('users', ['last_active_at' => now()]);
});
