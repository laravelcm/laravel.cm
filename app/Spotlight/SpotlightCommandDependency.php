<?php

declare(strict_types=1);

namespace App\Spotlight;

final class SpotlightCommandDependency
{
    public const string SEARCH = 'search';

    private string $placeholder = '';

    private string $type = self::SEARCH;

    public function __construct(
        private readonly string $identifier,
    ) {}

    public static function make(string $identifier): self
    {
        return new self($identifier);
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array{id: string, placeholder: string, type: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->identifier,
            'placeholder' => $this->placeholder,
            'type' => $this->type,
        ];
    }
}
