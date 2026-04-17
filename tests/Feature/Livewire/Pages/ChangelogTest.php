<?php

declare(strict_types=1);

use App\Livewire\Pages\Changelog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

describe(Changelog::class, function (): void {
    beforeEach(function (): void {
        Cache::flush();
    });

    it('renders the changelog page with releases from github', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/releases*' => Http::response([
                [
                    'tag_name' => 'v3.6.0',
                    'name' => 'v3.6.0: Laravel 13 Upgrade',
                    'body' => '## Highlights'.PHP_EOL.PHP_EOL.'Shipped in #527.',
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
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([
                ['login' => 'mckenziearts', 'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4'],
            ]),
        ]);

        Livewire::test(Changelog::class)
            ->assertOk()
            ->assertSee('v3.6.0')
            ->assertSee('Laravel 13 Upgrade')
            ->assertSee(__('pages/changelog.all_contributors'));
    });

    it('renders the empty state when no releases are returned', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([]),
        ]);

        Livewire::test(Changelog::class)
            ->assertOk()
            ->assertSee(__('pages/changelog.empty'));
    });

    it('renders all project contributors in the sticky aside', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/releases*' => Http::response([
                [
                    'tag_name' => 'v3.6.0',
                    'name' => 'v3.6.0',
                    'body' => '',
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
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([
                ['login' => 'mckenziearts', 'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4'],
                ['login' => 'contributorone', 'avatar_url' => 'https://avatars.githubusercontent.com/u/2?v=4'],
                ['login' => 'contributortwo', 'avatar_url' => 'https://avatars.githubusercontent.com/u/3?v=4'],
            ]),
        ]);

        Livewire::test(Changelog::class)
            ->assertOk()
            ->assertSee(__('pages/changelog.all_contributors'))
            ->assertSee('https://github.com/contributorone')
            ->assertSee('https://github.com/contributortwo');
    });

    it('transforms pr references in release body into github links', function (): void {
        $component = new Changelog;

        $html = $component->renderBody('Shipped in #527 and #528.');

        expect($html)
            ->toContain('href="https://github.com/laravelcm/laravel.cm/pull/527"')
            ->and($html)->toContain('>#527</a>')
            ->and($html)->toContain('href="https://github.com/laravelcm/laravel.cm/pull/528"');
    });

    it('strips unsafe url schemes from release body links', function (): void {
        $component = new Changelog;

        $html = $component->renderBody('[click me](javascript:alert(1)) and [data](data:text/html,<script>alert(1)</script>)');

        expect($html)
            ->not->toContain('javascript:')
            ->and($html)->not->toContain('data:text/html');
    });

    it('adds noopener, noreferrer and nofollow on external links from release body', function (): void {
        $component = new Changelog;

        $html = $component->renderBody('Visit [laravel.cm](https://laravel.cm) for more.');

        expect($html)
            ->toContain('target="_blank"')
            ->and($html)->toContain('noopener')
            ->and($html)->toContain('noreferrer')
            ->and($html)->toContain('nofollow');
    });

    it('does not double-wrap anchors that already have target or rel attributes', function (): void {
        $component = new Changelog;

        $html = $component->renderBody('See #527 and #528.');

        // PR references generate their own <a> with target/rel; the
        // enrichment pass must not double-insert those attributes.
        expect(mb_substr_count($html, 'target="_blank"'))->toBe(2)
            ->and(mb_substr_count($html, 'noreferrer'))->toBe(2);
    });

    it('is reachable via the named route', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([]),
        ]);

        $this->get(route('changelog'))->assertOk();
    });
});
