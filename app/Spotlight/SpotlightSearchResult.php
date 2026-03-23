<?php

declare(strict_types=1);

namespace App\Spotlight;

final class SpotlightSearchResult
{
    public function __construct(
        private readonly mixed $id,
        private readonly string $name,
        private readonly ?string $description = null,
        private readonly array $synonyms = [],
    ) {}

    public function getId(): mixed
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
}
