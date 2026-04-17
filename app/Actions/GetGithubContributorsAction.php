<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\ContributorData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class GetGithubContributorsAction
{
    private const string CACHE_KEY = 'github-contributors.v1';

    private const string ENDPOINT = 'https://api.github.com/repos/laravelcm/laravel.cm/contributors';

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
            callback: fn (): Collection => $this->fetch(),
        );
    }

    /**
     * @return Collection<int, ContributorData>
     */
    private function fetch(): Collection
    {
        /** @var string|null $token */
        $token = config('services.github.token');

        try {
            /** @var Response $response */
            $response = Http::when(
                filled($token),
                fn ($http) => $http->withToken($token), // @phpstan-ignore-line
            )
                ->acceptJson()
                ->timeout(5)
                ->retry(2, 200, throw: false)
                ->get(self::ENDPOINT, ['per_page' => self::MAX_CONTRIBUTORS]);
        } catch (ConnectionException) {
            Log::warning('Github contributors fetch failed: connection error');

            return collect();
        } catch (Throwable $exception) {
            Log::warning('Github contributors fetch failed', ['class' => $exception::class]);

            return collect();
        }

        if ($response->failed()) {
            Log::warning('Github contributors fetch returned non-2xx', ['status' => $response->status()]);

            return collect();
        }

        /** @var array<int, array{login?: string, avatar_url?: string}> $payload */
        $payload = $response->json();

        return collect($payload)
            ->filter(fn (array $contributor): bool => isset($contributor['login'])
                && $contributor['login'] !== ''
                && ! in_array(mb_strtolower($contributor['login']), self::EXCLUDED_CONTRIBUTORS, true),
            )
            ->map(function (array $contributor): ContributorData {
                /** @var array{login: string, avatar_url: string} $contributor */
                return new ContributorData(
                    login: $contributor['login'],
                    avatar: 'https://unavatar.io/github/'.$contributor['login'],
                );
            })
            ->values();
    }
}
