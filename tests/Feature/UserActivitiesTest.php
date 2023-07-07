<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(DatabaseMigrations::class);

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
