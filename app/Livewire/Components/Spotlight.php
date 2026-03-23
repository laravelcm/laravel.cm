<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

final class Spotlight extends Component
{
    /** @var array<class-string<SpotlightCommand>> */
    public static array $commands = [];

    /** @var array<int, array{id: mixed, name: string, description: ?string, synonyms: string[]}> */
    public array $dependencyQueryResults = [];

    public static function registerCommand(string $command): void
    {
        self::$commands[] = $command;
    }

    public static function registerCommandIf(bool $condition, string $command): void
    {
        if ($condition) {
            self::registerCommand($command);
        }
    }

    public static function registerCommandUnless(bool $condition, string $command): void
    {
        if (! $condition) {
            self::registerCommand($command);
        }
    }

    public function executeCommand(string $commandId): void
    {
        $command = $this->getCommandById($commandId);

        if (! $command) {
            return;
        }

        if (method_exists($command, 'execute')) {
            $params = ['spotlight' => $this];
            app()->call([$command, 'execute'], $params);

            return;
        }

        $url = $command->getUrl();

        if ($url !== '') {
            $this->dispatch('close-spotlight');
            $this->redirect($url, navigate: true);
        }
    }

    public function searchDependency(string $commandId, string $dependency, string $query, array $resolvedDependencies = []): void
    {
        $command = $this->getCommandById($commandId);

        if (! $command) {
            return;
        }

        $method = Str::camel('search '.$dependency);

        if (! method_exists($command, $method)) {
            return;
        }

        $params = array_merge(['query' => $query], $resolvedDependencies);

        $this->dependencyQueryResults = collect(app()->call([$command, $method], $params))
            ->map(fn (SpotlightSearchResult $result): array => [
                'id' => $result->getId(),
                'name' => $result->getName(),
                'description' => $result->getDescription(),
                'synonyms' => $result->getSynonyms(),
            ])
            ->toArray();
    }

    public function execute(string $commandId, array $dependencies = []): void
    {
        $command = $this->getCommandById($commandId);

        if (! $command || ! method_exists($command, 'execute')) {
            return;
        }

        $params = array_merge(['spotlight' => $this], $dependencies);

        app()->call([$command, 'execute'], $params);
    }

    public function render(): View
    {
        $commands = collect(self::$commands)
            ->map(fn (string $class): SpotlightCommand => app($class))
            ->filter(fn (SpotlightCommand $cmd): bool => $cmd->shouldBeShown(request()))
            ->map(fn (SpotlightCommand $cmd): array => $cmd->toArray())
            ->values()
            ->all();

        return view('livewire.components.spotlight', [
            'commands' => $commands,
        ]);
    }

    private function getCommandById(string $id): ?SpotlightCommand
    {
        /** @var SpotlightCommand|null */
        return collect(self::$commands)
            ->map(fn (string $class): SpotlightCommand => app($class))
            ->first(fn (SpotlightCommand $cmd): bool => $cmd->getId() === $id);
    }
}
