<?php

declare(strict_types=1);

use App\Console\Commands\NotifyPendingArticles;
use App\Models\Article;
use Illuminate\Support\Facades\Notification;

beforeEach(fn () => Notification::fake());

it('will send a notification when there are pending articles', function (): void {
    Article::factory()->createMany([
        [
            'submitted_at' => now(),
        ],
        [
            'submitted_at' => now()->subDay(),
            'approved_at' => now(),
        ],
        [
            'submitted_at' => now()->subDay(),
            'declined_at' => now(),
        ],
    ]);

    $this->assertDatabaseCount('articles', 3);
    $this->artisan(NotifyPendingArticles::class)->assertExitCode(0);

    Notification::assertCount(1);
});

it('will not send a notification when there are no pending articles', function (): void {
    Article::factory()->createMany([
        [
            'submitted_at' => now()->subDay(),
            'approved_at' => now(),
        ],
        [
            'submitted_at' => now()->subDay(),
            'declined_at' => now(),
        ],
    ]);

    $this->assertDatabaseCount('articles', 2);
    $this->artisan(NotifyPendingArticles::class)->assertExitCode(0);

    Notification::assertNothingSent();
    Notification::assertCount(0);
});
