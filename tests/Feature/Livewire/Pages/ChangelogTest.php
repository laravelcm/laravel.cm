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

    it('is reachable via the named route', function (): void {
        Http::fake([
            'api.github.com/*' => Http::response([]),
        ]);

        $this->get(route('changelog'))->assertOk();
    });
});
