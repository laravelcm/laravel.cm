<?php

declare(strict_types=1);

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;

describe('sentinel:check-canonicals', function (): void {
    it('detects broken external canonical urls', function (): void {
        Http::fake([
            'https://broken-site.com/*' => Http::response('Not Found', 404),
        ]);

        $article = Article::factory()->approved()->create([
            'canonical_url' => 'https://broken-site.com/old-post',
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(
            ContentIssue::query()
                ->where('issueable_id', $article->id)
                ->where('type', IssueType::BrokenCanonical)
                ->where('status', IssueStatus::Detected)
                ->exists()
        )->toBeTrue();
    });

    it('skips articles with valid canonical urls', function (): void {
        Http::fake([
            'https://valid-site.com/*' => Http::response('OK', 200),
        ]);

        Article::factory()->approved()->create([
            'canonical_url' => 'https://valid-site.com/post',
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(ContentIssue::query()->count())->toBe(0);
    });

    it('skips articles with internal canonical urls', function (): void {
        Article::factory()->approved()->create([
            'canonical_url' => config('app.url').'/articles/my-post',
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(ContentIssue::query()->count())->toBe(0);
    });

    it('skips articles without canonical url', function (): void {
        Article::factory()->approved()->create([
            'canonical_url' => null,
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(ContentIssue::query()->count())->toBe(0);
    });

    it('handles unreachable urls gracefully', function (): void {
        Http::fake([
            'https://unreachable.test/*' => Http::throw(fn () => throw new RuntimeException('Connection refused')),
        ]);

        $article = Article::factory()->approved()->create([
            'canonical_url' => 'https://unreachable.test/post',
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(
            ContentIssue::query()
                ->where('issueable_id', $article->id)
                ->where('type', IssueType::BrokenCanonical)
                ->exists()
        )->toBeTrue();
    });

    it('falls back to GET when HEAD returns 405', function (): void {
        Http::fake([
            'https://no-head.com/*' => Http::sequence()
                ->push('Method Not Allowed', 405)
                ->push('OK', 200),
        ]);

        Article::factory()->approved()->create([
            'canonical_url' => 'https://no-head.com/post',
        ]);

        $this->artisan('sentinel:check-canonicals')
            ->assertSuccessful();

        expect(ContentIssue::query()->count())->toBe(0);
    });
});
