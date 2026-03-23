<?php

declare(strict_types=1);

namespace App\Spotlight;

use Illuminate\Http\Request;

final class SpotlightManager
{
    /** @var array<string, class-string<SpotlightCommand>> */
    private array $commands = [];

    /**
     * @param  class-string<SpotlightCommand>  $command
     */
    public function register(string $command): self
    {
        $instance = resolve($command);
        $this->commands[$instance->getId()] = $command;

        return $this;
    }

    /**
     * @param  class-string<SpotlightCommand>  $command
     */
    public function registerIf(bool $condition, string $command): self
    {
        if ($condition) {
            $this->register($command);
        }

        return $this;
    }

    /**
     * @param  class-string<SpotlightCommand>  $command
     */
    public function registerUnless(bool $condition, string $command): self
    {
        if (! $condition) {
            $this->register($command);
        }

        return $this;
    }

    public function getCommandById(string $id): ?SpotlightCommand
    {
        if (! isset($this->commands[$id])) {
            return null;
        }

        return resolve($this->commands[$id]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getVisibleCommands(Request $request): array
    {
        return collect($this->commands)
            ->map(fn (string $class): SpotlightCommand => resolve($class))
            ->filter(fn (SpotlightCommand $cmd): bool => $cmd->shouldBeShown($request))
            ->map(fn (SpotlightCommand $cmd): array => $cmd->toArray())
            ->values()
            ->all();
    }
}
