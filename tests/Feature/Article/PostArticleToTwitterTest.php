<?php

declare(strict_types=1);

use App\Models\Article;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Notification;
use App\Console\Commands\PostArticleToTwitter;

beforeEach(fn () => 
Notification::fake(), 
TestTime::freeze('Y-m-d H:i:s', '2021-05-01 00:00:01')
);

describe(PostArticleToTwitter::class, function() {
    it('shares one article on Twitter every 4 hours when the artisan command runs', function (): void {
        Article::factory()->createMany([
            ['submitted_at' => now()],
            ['submitted_at' => now(), 'approved_at' => now(),  'published_at' => now()],
            ['submitted_at' => now(), 'approved_at' => now(),  'published_at' => now()->addHours(1)],
            ['submitted_at' => now(), 'declined_at' => now()],
        ]);
    
        $this->assertDatabaseCount('articles', 4);
    
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(1); 
    
        TestTime::addHours(4);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(2); 
    
        TestTime::addHours(4);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
        Notification::assertCount(2);
    });
    
    it('will not send article when there are not articles to share', function (): void {
        Article::factory()->createMany([
            ['submitted_at' => now(),'approved_at' => now(),'shared_at' => now()],
            ['submitted_at' => now(),'approved_at' => now(),'shared_at' => now()],
        ]);
    
        $this->assertDatabaseCount('articles', 2);
        $this->artisan(PostArticleToTwitter::class)->assertExitCode(0);
    
        Notification::assertNothingSent();
        Notification::assertCount(0);
    });
});