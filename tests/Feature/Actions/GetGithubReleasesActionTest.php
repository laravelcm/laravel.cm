<?php

declare(strict_types=1);

use App\Actions\GetGithubReleasesAction;
use App\Data\ReleaseData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

describe(GetGithubReleasesAction::class, function (): void {
    beforeEach(function (): void {
        Cache::flush();
    });

    it('fetches published releases from github and hydrates them into release data', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([
                [
                    'tag_name' => 'v3.6.0',
                    'name' => 'v3.6.0: Laravel 13 Upgrade',
                    'body' => '## Highlights',
                    'html_url' => 'https://github.com/laravelcm/laravel.cm/releases/tag/v3.6.0',
                    'published_at' => '2026-04-17T06:42:54Z',
                    'draft' => false,
                    'prerelease' => false,
                    'author' => [
                        'login' => 'mckenziearts',
                        'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                        'html_url' => 'https://github.com/mckenziearts',
                    ],
                ],
            ]),
        ]);

        $releases = resolve(GetGithubReleasesAction::class)();

        expect($releases)->toHaveCount(1)
            ->and($releases->first())->toBeInstanceOf(ReleaseData::class)
            ->and($releases->first()->tag_name)->toBe('v3.6.0')
            ->and($releases->first()->author->login)->toBe('mckenziearts');
    });

    it('filters out draft releases', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([
                [
                    'tag_name' => 'v3.6.0',
                    'name' => 'v3.6.0',
                    'body' => '...',
                    'html_url' => 'https://github.com/laravelcm/laravel.cm/releases/tag/v3.6.0',
                    'published_at' => '2026-04-17T06:42:54Z',
                    'draft' => false,
                    'prerelease' => false,
                    'author' => [
                        'login' => 'mckenziearts',
                        'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                        'html_url' => 'https://github.com/mckenziearts',
                    ],
                ],
                [
                    'tag_name' => 'v4.0.0-draft',
                    'name' => 'Draft',
                    'body' => '',
                    'html_url' => 'https://github.com/laravelcm/laravel.cm/releases/tag/v4.0.0-draft',
                    'published_at' => '2026-04-17T06:42:54Z',
                    'draft' => true,
                    'prerelease' => false,
                    'author' => [
                        'login' => 'mckenziearts',
                        'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                        'html_url' => 'https://github.com/mckenziearts',
                    ],
                ],
            ]),
        ]);

        $releases = resolve(GetGithubReleasesAction::class)();

        expect($releases)->toHaveCount(1)
            ->and($releases->first()->tag_name)->toBe('v3.6.0');
    });

    it('caches results and does not hit github twice', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([
                [
                    'tag_name' => 'v3.6.0',
                    'name' => 'v3.6.0',
                    'body' => '...',
                    'html_url' => 'https://github.com/laravelcm/laravel.cm/releases/tag/v3.6.0',
                    'published_at' => '2026-04-17T06:42:54Z',
                    'draft' => false,
                    'prerelease' => false,
                    'author' => [
                        'login' => 'mckenziearts',
                        'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                        'html_url' => 'https://github.com/mckenziearts',
                    ],
                ],
            ]),
        ]);

        resolve(GetGithubReleasesAction::class)();
        resolve(GetGithubReleasesAction::class)();

        Http::assertSentCount(1);
    });

    it('returns empty collection on api failure', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([], 500),
        ]);

        $releases = resolve(GetGithubReleasesAction::class)();

        expect($releases)->toBeEmpty();
    });
});
