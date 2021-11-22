<?php

use App\Models\Activity;
use App\Models\Article;
use Carbon\Carbon;

it('records activity when an article is created', function () {
    actingAs();

    $article = Article::factory()->create(['user_id' => auth()->id()]);

    $this->assertDatabaseHas('activities', [
        'type' => 'created_article',
        'user_id' => auth()->id(),
        'subject_id' => $article->id,
        'subject_type' => 'article',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $article->id);
});

it('get feed from any user', function () {
    actingAs();

    Article::factory()->count(2)->create(['user_id' => auth()->id()]);
    auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

    $feed = Activity::feed(auth()->user());

    $this->assertTrue($feed->keys()->contains(
        Carbon::now()->format('Y-m-d')
    ));

    $this->assertFalse($feed->keys()->contains(
        Carbon::now()->subWeek()->format('Y-m-d')
    ));
});
