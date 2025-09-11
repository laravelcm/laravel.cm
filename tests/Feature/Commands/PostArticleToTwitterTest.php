<?php

declare(strict_types=1);

use App\Console\Commands\PostArticleToTwitter;
use App\Models\Article;
use Illuminate\Support\Facades\Notification;
use Spatie\TestTime\TestTime;

beforeEach(function (): void {
    Notification::fake();

    TestTime::freeze('Y-m-d H:i:s', '2021-05-01 00:00:01');
});

describe(PostArticleToTwitter::class, function (): void {
    it('shares one article on Twitter every 4 hours when the artisan command runs', function (): void {
        Article::factory()->createMany([
            ['submitted_at' => now()],
            ['submitted_at' => now(), 'approved_at' => now(), 'published_at' => now()],
            ['submitted_at' => now(), 'approved_at' => now(), 'published_at' => now()->addHour()],
            ['submitted_at' => now(), 'declined_at' => now()],
        ]);

        $this->assertDatabaseCount('articles', 4);

        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(0);

        TestTime::addHours(4);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(0);

        TestTime::addHours(4);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(0);
    });

    it('will not send article when there are not articles to share', function (): void {
        Article::factory()->createMany([
            ['submitted_at' => now(), 'approved_at' => now(), 'shared_at' => now()],
            ['submitted_at' => now(), 'approved_at' => now(), 'shared_at' => now()],
        ]);

        $this->assertDatabaseCount('articles', 2);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);

        Notification::assertNothingSent();
        Notification::assertCount(0);
    });
});
