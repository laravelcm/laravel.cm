<?php

declare(strict_types=1);

use App\Actions\GetGithubContributorsAction;
use App\Data\ContributorData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

describe(GetGithubContributorsAction::class, function (): void {
    beforeEach(function (): void {
        Cache::flush();
    });

    it('fetches and hydrates all contributors from github', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([
                ['login' => 'mckenziearts', 'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4'],
                ['login' => 'johndoe', 'avatar_url' => 'https://avatars.githubusercontent.com/u/2?v=4'],
            ]),
        ]);

        $contributors = resolve(GetGithubContributorsAction::class)();

        expect($contributors)->toHaveCount(2)
            ->and($contributors->first())->toBeInstanceOf(ContributorData::class)
            ->and($contributors->first()->login)->toBe('mckenziearts')
            ->and($contributors->first()->avatar)->toBe('https://avatars.githubusercontent.com/u/1?v=4');
    });

    it('filters out bots', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([
                ['login' => 'mckenziearts', 'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4'],
                ['login' => 'dependabot[bot]', 'avatar_url' => 'https://avatars.githubusercontent.com/in/29110?v=4'],
                ['login' => 'github-actions[bot]', 'avatar_url' => 'https://avatars.githubusercontent.com/in/15368?v=4'],
                ['login' => 'johndoe', 'avatar_url' => 'https://avatars.githubusercontent.com/u/2?v=4'],
            ]),
        ]);

        $contributors = resolve(GetGithubContributorsAction::class)();

        expect($contributors)->toHaveCount(2)
            ->and($contributors->pluck('login')->all())->toBe(['mckenziearts', 'johndoe']);
    });

    it('caches results and does not hit github twice', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([
                ['login' => 'mckenziearts', 'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4'],
            ]),
        ]);

        resolve(GetGithubContributorsAction::class)();
        resolve(GetGithubContributorsAction::class)();

        Http::assertSentCount(1);
    });

    it('returns empty collection on api failure', function (): void {
        Http::fake([
            'api.github.com/repos/laravelcm/laravel.cm/contributors*' => Http::response([], 500),
        ]);

        $contributors = resolve(GetGithubContributorsAction::class)();

        expect($contributors)->toBeEmpty();
    });
});
