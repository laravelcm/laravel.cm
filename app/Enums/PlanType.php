<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PlanType: string implements HasLabel
{
    case DEVELOPER = 'developer';

    case ENTERPRISE = 'enterprise';

    public function getLabel(): string
    {
        return match ($this) {
            self::DEVELOPER => __('Développeur'),
            self::ENTERPRISE => __('Entreprise'),
        };
    }
}
