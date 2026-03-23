<?php

declare(strict_types=1);

namespace App\Spotlight;

final class SpotlightResultOptions
{
    public function __construct(
        public readonly ?string $badgeLabel = null,
        public readonly ?string $badgeColor = null,
    ) {}

    /**
     * @return array{badge_label: ?string, badge_color: ?string}
     */
    public function toArray(): array
    {
        return [
            'badge_label' => $this->badgeLabel,
            'badge_color' => $this->badgeColor,
        ];
    }
}
