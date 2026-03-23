<?php

declare(strict_types=1);

namespace App\Spotlight;

use Illuminate\Support\Collection;

final class SpotlightCommandDependencies
{
    /** @var Collection<int, SpotlightCommandDependency> */
    private Collection $dependencies;

    public function __construct()
    {
        $this->dependencies = new Collection;
    }

    public static function collection(): self
    {
        return new self;
    }

    public function add(SpotlightCommandDependency $dependency): self
    {
        $this->dependencies->push($dependency);

        return $this;
    }

    /**
     * @return array<int, array{id: string, placeholder: string, type: string}>
     */
    public function toArray(): array
    {
        return $this->dependencies
            ->map(fn (SpotlightCommandDependency $dep): array => $dep->toArray())
            ->reverse()
            ->values()
            ->all();
    }
}
