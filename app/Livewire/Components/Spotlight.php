<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightManager;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

final class Spotlight extends Component
{
    private const int MAX_QUERY_LENGTH = 100;

    private const int SEARCH_RATE_LIMIT = 30;

    /** @var array<int, array{id: int|string, name: string, description: ?string, synonyms: array<string>, image: ?string, options: ?array{badge_label: ?string, badge_color: ?string}}> */
    public array $dependencyQueryResults = [];

    public function executeCommand(string $commandId): void
    {
        $command = resolve(SpotlightManager::class)->getCommandById($commandId);

        if (! $command || ! method_exists($command, 'execute')) {
            return;
        }

        app()->call([$command, 'execute'], ['spotlight' => $this]);
    }

    public function searchDependency(string $commandId, string $dependency, string $query, array $resolvedDependencies = []): void
    {
        $query = $this->sanitizeQuery($query);

        if ($query === '') {
            $this->dependencyQueryResults = [];

            return;
        }

        if ($this->isRateLimited()) {
            return;
        }

        $command = resolve(SpotlightManager::class)->getCommandById($commandId);

        if (! $command) {
            return;
        }

        if (! $this->isValidDependency($command, $dependency)) {
            return;
        }

        $method = Str::camel('search '.$dependency);

        $params = array_merge(['query' => $query], $resolvedDependencies);

        /** @var Collection<int, SpotlightSearchResult> $results */
        $results = app()->call([$command, $method], $params); // @phpstan-ignore argument.type

        $this->dependencyQueryResults = $results
            ->map(fn (SpotlightSearchResult $result): array => [
                'id' => $result->getId(),
                'name' => $result->getName(),
                'description' => $result->getDescription(),
                'synonyms' => $result->getSynonyms(),
                'image' => $result->getImage(),
                'options' => $result->getOptions()?->toArray(),
            ])
            ->values()
            ->all();
    }

    public function execute(string $commandId, array $dependencies = []): void
    {
        $command = resolve(SpotlightManager::class)->getCommandById($commandId);

        if (! $command || ! method_exists($command, 'execute')) {
            return;
        }

        $params = array_merge(['spotlight' => $this], $dependencies);

        app()->call([$command, 'execute'], $params);
    }

    public function render(): View
    {
        return view('livewire.components.spotlight', [
            'commands' => resolve(SpotlightManager::class)->getVisibleCommands(request()),
        ]);
    }

    private function sanitizeQuery(string $query): string
    {
        return mb_substr(mb_trim(strip_tags($query)), 0, self::MAX_QUERY_LENGTH);
    }

    private function isRateLimited(): bool
    {
        $key = 'spotlight-search:'.(auth()->id() ?? request()->ip());

        if (RateLimiter::tooManyAttempts($key, self::SEARCH_RATE_LIMIT)) {
            return true;
        }

        RateLimiter::hit($key);

        return false;
    }

    private function isValidDependency(SpotlightCommand $command, string $dependency): bool
    {
        $dependencies = $command->dependencies();

        if (! $dependencies instanceof \App\Spotlight\SpotlightCommandDependencies) {
            return false;
        }

        $validIds = collect($dependencies->toArray())->pluck('id')->all();

        return in_array($dependency, $validIds, true);
    }
}
