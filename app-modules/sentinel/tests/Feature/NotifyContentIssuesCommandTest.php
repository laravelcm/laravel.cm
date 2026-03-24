<?php

declare(strict_types=1);

use App\Models\Article;
use Illuminate\Support\Facades\Notification;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;
use Laravelcm\Sentinel\Notifications\ContentIssuesDetectedNotification;

describe('sentinel:notify', function (): void {
    it('notifies authors with detected issues', function (): void {
        Notification::fake();

        $article = Article::factory()->approved()->create();

        ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::MissingHttps,
            'status' => IssueStatus::Detected,
            'details' => ['match' => '[site](example.com)'],
            'detected_at' => now(),
        ]);

        $this->artisan('sentinel:notify')
            ->assertSuccessful();

        Notification::assertSentTo($article->user, ContentIssuesDetectedNotification::class);
    });

    it('sets status to notified with deadline', function (): void {
        Notification::fake();

        $article = Article::factory()->approved()->create();

        $issue = ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::FailedUpload,
            'status' => IssueStatus::Detected,
            'details' => ['match' => '![img](Uploading...)'],
            'detected_at' => now(),
        ]);

        $this->artisan('sentinel:notify')
            ->assertSuccessful();

        $issue->refresh();

        expect($issue->status)->toBe(IssueStatus::Notified)
            ->and($issue->notified_at)->not->toBeNull()
            ->and($issue->deadline_at)->not->toBeNull();
    });

    it('groups multiple issues per author into one notification', function (): void {
        Notification::fake();

        $article1 = Article::factory()->approved()->create();
        $article2 = Article::factory()->approved()->create(['user_id' => $article1->user_id]);

        ContentIssue::factory()->create([
            'issueable_id' => $article1->id,
            'issueable_type' => $article1->getMorphClass(),
            'type' => IssueType::MissingHttps,
            'status' => IssueStatus::Detected,
            'details' => ['match' => '[a](a.com)'],
            'detected_at' => now(),
        ]);

        ContentIssue::factory()->create([
            'issueable_id' => $article2->id,
            'issueable_type' => $article2->getMorphClass(),
            'type' => IssueType::FailedUpload,
            'status' => IssueStatus::Detected,
            'details' => ['match' => '![b](Uploading...)'],
            'detected_at' => now(),
        ]);

        $this->artisan('sentinel:notify')
            ->assertSuccessful();

        Notification::assertSentToTimes($article1->user, ContentIssuesDetectedNotification::class, 1);
    });

    it('does nothing when no issues exist', function (): void {
        Notification::fake();

        $this->artisan('sentinel:notify')
            ->assertSuccessful();

        Notification::assertNothingSent();
    });

    it('ignores already notified issues', function (): void {
        Notification::fake();

        $article = Article::factory()->approved()->create();

        ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::MissingHttps,
            'status' => IssueStatus::Notified,
            'details' => ['match' => '[a](a.com)'],
            'detected_at' => now(),
            'notified_at' => now(),
            'deadline_at' => now()->addDays(30),
        ]);

        $this->artisan('sentinel:notify')
            ->assertSuccessful();

        Notification::assertNothingSent();
    });
});
