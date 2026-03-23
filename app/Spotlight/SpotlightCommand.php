<?php

declare(strict_types=1);

namespace App\Spotlight;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class SpotlightCommand
{
    protected string $name = '';

    protected ?string $icon = null;

    protected ?string $group = null;

    /** @var string[] */
    protected array $synonyms = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return '';
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @return string[]
     */
    public function getSynonyms(): array
    {
        return $this->synonyms;
    }

    public function getId(): string
    {
        return Str::kebab(class_basename(static::class));
    }

    public function shouldBeShown(Request $request): bool
    {
        return true;
    }

    public function closesAfterExecute(): bool
    {
        return true;
    }

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return null;
    }

    /**
     * @return array{id: string, name: string, description: string, icon: ?string, group: ?string, synonyms: string[], dependencies: array}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'icon' => $this->getIcon(),
            'group' => $this->getGroup(),
            'synonyms' => $this->getSynonyms(),
            'dependencies' => $this->dependencies()?->toArray() ?? [],
            'closesAfterExecute' => $this->closesAfterExecute(),
        ];
    }
}
