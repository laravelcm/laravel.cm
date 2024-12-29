<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\RepositoryData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class GetGithubRepositoriesAction
{
    public function __invoke(): Collection
    {
        $response = Http::withToken(config('services.github.token'))
            ->get('https://api.github.com/orgs/laravelcd/repos');

        if (Cache::has('github-repositories')) {
            return Cache::get('github-repositories');
        }

        $only = [
            'laravel-subscriptions',
            'livewire-slide-overs',
            'abstract-ip-geolocation',
            'angular-admin-panel',
        ];

        return Cache::remember(
            key: 'github-repositories',
            ttl: now()->addWeek(),
            callback: fn () => collect($response->json())
                ->reject(fn (array $value) => $value['fork'] === true || ! in_array($value['name'], $only))
                ->map(fn (array $data) => RepositoryData::from($data))
        );
    }
}
