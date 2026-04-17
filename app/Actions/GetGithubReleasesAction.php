<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\ContributorData;
use App\Data\ReleaseAuthorData;
use App\Data\ReleaseData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class GetGithubReleasesAction
{
    private const string CACHE_KEY = 'github-releases';

    private const string ENDPOINT = 'https://api.github.com/repos/laravelcm/laravel.cm/releases';

    private const int MAX_RELEASES = 10;

    private const array EXCLUDED_CONTRIBUTORS = [
        'dependabot',
        'github-actions',
        'dependabot-preview',
    ];

    /**
     * @return Collection<int, ReleaseData>
     */
    public function __invoke(): Collection
    {
        /** @var Collection<int, ReleaseData> */
        return Cache::flexible(
            key: self::CACHE_KEY,
            ttl: [now()->addDays(3), now()->addDays(5)],
            callback: fn (): Collection => $this->fetch(),
        );
    }

    /**
     * @return Collection<int, ReleaseData>
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
                ->get(self::ENDPOINT, ['per_page' => self::MAX_RELEASES]);
        } catch (ConnectionException) {
            Log::warning('Github releases fetch failed: connection error');

            return collect();
        } catch (Throwable $exception) {
            Log::warning('Github releases fetch failed', ['class' => $exception::class]);

            return collect();
        }

        if ($response->failed()) {
            Log::warning('Github releases fetch returned non-2xx', ['status' => $response->status()]);

            return collect();
        }

        /** @var array<int, array<string, mixed>> $payload */
        $payload = $response->json();

        return collect($payload)
            ->reject(fn (array $release): bool => (bool) ($release['draft'] ?? false))
            ->take(self::MAX_RELEASES)
            ->map(function (array $release): ReleaseData {
                /** @var array{tag_name: string, name: ?string, body: ?string, html_url: string, published_at: string, author: array{login: string, avatar_url: string, html_url: string}, prerelease?: bool} $release */
                return $this->toReleaseData($release);
            })
            ->values();
    }

    /**
     * @param  array{tag_name: string, name: ?string, body: ?string, html_url: string, published_at: string, author: array{login: string, avatar_url: string, html_url: string}, prerelease?: bool}  $release
     */
    private function toReleaseData(array $release): ReleaseData
    {
        $author = ReleaseAuthorData::from($release['author']);
        $body = $release['body'] ?? '';

        return new ReleaseData(
            tag_name: $release['tag_name'],
            name: $release['name'] ?? $release['tag_name'],
            body: $body,
            html_url: $release['html_url'],
            published_at: Date::parse($release['published_at']),
            author: $author,
            contributors: $this->extractContributors($body, $author),
            prerelease: $release['prerelease'] ?? false,
        );
    }

    /**
     * @return Collection<int, ContributorData>
     */
    private function extractContributors(string $body, ReleaseAuthorData $author): Collection
    {
        $contributors = collect([
            new ContributorData(
                login: $author->login,
                avatar: 'https://unavatar.io/github/'.$author->login,
            ),
        ]);

        preg_match_all('/@([\w-]+)\s+in\s+https:\/\/github\.com/', $body, $matches);

        $seen = [mb_strtolower($author->login)];

        foreach ($matches[1] as $login) {
            $lower = mb_strtolower($login);

            if (in_array($lower, $seen, true)) {
                continue;
            }

            if (in_array($lower, self::EXCLUDED_CONTRIBUTORS, true)) {
                continue;
            }

            $seen[] = $lower;
            $contributors->push(new ContributorData(
                login: $login,
                avatar: 'https://unavatar.io/github/'.$login,
            ));
        }

        return $contributors;
    }
}
