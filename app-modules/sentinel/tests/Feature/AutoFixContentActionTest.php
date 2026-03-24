<?php

declare(strict_types=1);

use App\Models\Article;
use Laravelcm\Sentinel\Actions\AutoFixContentAction;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;

describe(AutoFixContentAction::class, function (): void {
    it('fixes missing https by adding the prefix', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Visit [Behance](behance.net) for inspiration.',
        ]);

        $issue = ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::MissingHttps,
            'status' => IssueStatus::Notified,
            'details' => ['match' => '[Behance](behance.net)'],
            'detected_at' => now()->subDays(31),
            'deadline_at' => now()->subDay(),
        ]);

        $result = (new AutoFixContentAction)->execute($issue);

        expect($result)->toBeTrue()
            ->and($article->fresh()->body)->toBe('Visit [Behance](https://behance.net) for inspiration.')
            ->and($issue->fresh()->status)->toBe(IssueStatus::AutoFixed)
            ->and($issue->fresh()->resolved_at)->not->toBeNull();
    });

    it('removes failed upload references', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Text before ![screenshot.png](Uploading...) text after.',
        ]);

        $issue = ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::FailedUpload,
            'status' => IssueStatus::Notified,
            'details' => ['match' => '![screenshot.png](Uploading...)'],
            'detected_at' => now()->subDays(31),
            'deadline_at' => now()->subDay(),
        ]);

        $result = (new AutoFixContentAction)->execute($issue);

        expect($result)->toBeTrue()
            ->and($article->fresh()->body)->toBe('Text before text after.')
            ->and($issue->fresh()->status)->toBe(IssueStatus::AutoFixed);
    });

    it('returns false when match is empty', function (): void {
        $article = Article::factory()->approved()->create(['body' => 'content']);

        $issue = ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::MissingHttps,
            'status' => IssueStatus::Notified,
            'details' => [],
            'detected_at' => now(),
        ]);

        expect((new AutoFixContentAction)->execute($issue))->toBeFalse();
    });

    it('returns false for broken canonical type', function (): void {
        $article = Article::factory()->approved()->create(['body' => 'content']);

        $issue = ContentIssue::factory()->create([
            'issueable_id' => $article->id,
            'issueable_type' => $article->getMorphClass(),
            'type' => IssueType::BrokenCanonical,
            'status' => IssueStatus::Notified,
            'details' => ['match' => 'something'],
            'detected_at' => now(),
        ]);

        expect((new AutoFixContentAction)->execute($issue))->toBeFalse();
    });
});
