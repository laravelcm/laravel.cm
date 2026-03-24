<?php

declare(strict_types=1);

use App\Models\Article;
use Laravelcm\Sentinel\Actions\ScanContentAction;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;

describe('ScanContentAction', function (): void {
    it('detects missing https in markdown links', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Check [Behance](behance.net) for design.',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toHaveCount(1)
            ->and($issues[0]['type'])->toBe(IssueType::MissingHttps)
            ->and($issues[0]['details']['match'])->toBe('[Behance](behance.net)');
    });

    it('ignores links with https', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Check [Behance](https://behance.net) for design.',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toBeEmpty();
    });

    it('ignores relative links and anchors', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'See [home](/home) and [section](#intro) and [mail](mailto:test@test.com).',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toBeEmpty();
    });

    it('detects failed uploads', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Here is an image ![screenshot.png](Uploading...) in the text.',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toHaveCount(1)
            ->and($issues[0]['type'])->toBe(IssueType::FailedUpload);
    });

    it('does not count Uploading as missing https', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => '![file](Uploading...)',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toHaveCount(1)
            ->and($issues[0]['type'])->toBe(IssueType::FailedUpload);
    });

    it('detects multiple issues in the same content', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => '[site](example.com) and ![img](Uploading...) and [other](test.org)',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toHaveCount(3);
    });

    it('creates content issues in database', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => '[Dribbble](dribbble.com)',
        ]);

        (new ScanContentAction)->execute($article);

        $article->refresh();

        expect($article->contentIssues)->toHaveCount(1)
            ->and($article->contentIssues->first()->type)->toBe(IssueType::MissingHttps)
            ->and($article->contentIssues->first()->status)->toBe(IssueStatus::Detected);
    });

    it('does not duplicate issues on re-scan', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => '[site](example.com)',
        ]);

        $action = new ScanContentAction;
        $action->execute($article);
        $action->execute($article);

        expect($article->contentIssues()->count())->toBe(1);
    });

    it('resolves issues when content is fixed', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => '[site](example.com)',
        ]);

        $action = new ScanContentAction;
        $action->execute($article);

        $article->updateQuietly(['body' => '[site](https://example.com)']);
        $action->execute($article->fresh());

        expect($article->contentIssues()->where('status', IssueStatus::Resolved)->count())->toBe(1)
            ->and($article->contentIssues()->where('status', IssueStatus::Detected)->count())->toBe(0);
    });

    it('returns empty for clean content', function (): void {
        $article = Article::factory()->approved()->create([
            'body' => 'Just some text without any links.',
        ]);

        $issues = (new ScanContentAction)->execute($article);

        expect($issues)->toBeEmpty();
    });
});
