<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\ContributorData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class GetGithubContributorsAction extends AbstractGithubApiAction
{
    private const string CACHE_KEY = 'github-contributors.v2';

    private const int MAX_CONTRIBUTORS = 100;

    private const array EXCLUDED_CONTRIBUTORS = [
        'dependabot',
        'dependabot[bot]',
        'github-actions',
        'github-actions[bot]',
        'dependabot-preview',
    ];

    /**
     * @return Collection<int, ContributorData>
     */
    public function __invoke(): Collection
    {
        /** @var Collection<int, ContributorData> */
        return Cache::flexible(
            key: self::CACHE_KEY,
            ttl: [now()->addDays(7), now()->addDays(14)],
            callback: fn (): Collection => $this->collect(),
        );
    }

    protected function endpoint(): string
    {
        return 'https://api.github.com/repos/laravelcm/laravel.cm/contributors';
    }

    /**
     * @return array<string, int|string>
     */
    protected function queryParameters(): array
    {
        return ['per_page' => self::MAX_CONTRIBUTORS];
    }

    protected function errorLogPrefix(): string
    {
        return 'Github contributors fetch failed';
    }

    /**
     * @return Collection<int, ContributorData>
     */
    private function collect(): Collection
    {
        $payload = $this->fetch();

        if ($payload === null) {
            return collect();
        }

        /** @var array<int, array{login?: string, avatar_url?: string}> $payload */
        return collect($payload)
            ->filter(
                fn (array $contributor): bool => isset($contributor['login'])
                && $contributor['login'] !== ''
                && ! in_array(mb_strtolower($contributor['login']), self::EXCLUDED_CONTRIBUTORS, true),
            )
            ->map(function (array $contributor): ContributorData {
                /** @var array{login: string, avatar_url: string} $contributor */
                return new ContributorData(
                    login: $contributor['login'],
                    avatar: $contributor['avatar_url'],
                );
            })
            ->values();
    }
}
