<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Article;
use Carbon\Carbon;

/**
 * @var \Tests\TestCase $this
 */
beforeEach(function (): void {
    $this->user = $this->login();
});

describe('User Activities', function (): void {
    it('records activity when an article is created', function (): void {
        $article = Article::factory(['user_id' => $this->user->id])->create();
        $activity = Activity::query()->first();

        expect($activity->subject->id)
            ->toEqual($article->id)
            ->and(Activity::query()->count())
            ->toEqual(1);
    });

    it('get feed from any user', function (): void {
        Article::factory(['user_id' => $this->user->id])
            ->count(2)
            ->create();

        $this->user->activities()
            ->first()
            ->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($this->user);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertFalse($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    });
});
