<?php

declare(strict_types=1);

namespace App\Spotlight;

final class SpotlightSearchResult
{
    public function __construct(
        private readonly int|string $id,
        private readonly string $name,
        private readonly ?string $description = null,
        private readonly array $synonyms = [],
        private readonly ?string $image = null,
        private readonly ?SpotlightResultOptions $options = null,
    ) {}

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getSynonyms(): array
    {
        return $this->synonyms;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getOptions(): ?SpotlightResultOptions
    {
        return $this->options;
    }
}
