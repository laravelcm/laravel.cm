<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\RepositoryData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class GetGithubRepositoriesAction
{
    /**
     * @return Collection<int, RepositoryData>
     *
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function __invoke(): Collection
    {
        if (Cache::has('github-repositories')) {
            /** @var Collection<int, RepositoryData> */
            return Cache::get('github-repositories');
        }

        /** @var string $token */
        $token = config('services.github.token');
        /** @var Response $response */
        $response = Http::withToken($token)
            ->get('https://api.github.com/orgs/laravelcm/repos');

        $only = [
            'laravel-subscriptions',
            'livewire-slide-overs',
            'abstract-ip-geolocation',
            'angular-admin-panel',
            'filament-starter-kit',
        ];

        /** @var array<int, array<string, mixed>> $responseData */
        $responseData = $response->json();

        /** @var Collection<int, RepositoryData> */
        return Cache::remember(
            key: 'github-repositories',
            ttl: now()->addMonth(),
            callback: fn (): Collection => collect($responseData)
                ->reject(fn (array $value): bool => $value['fork'] === true || ! in_array($value['name'], $only))
                ->map(fn (array $data): RepositoryData => RepositoryData::from($data))
        );
    }
}
