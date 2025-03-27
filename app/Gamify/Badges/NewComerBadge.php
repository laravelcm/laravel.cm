<?php

declare(strict_types=1);

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

final class NewComerBadge extends BadgeType
{
    protected string $name = 'badges.new_comer.title';

    protected string $description = 'badges.new_comer.description';

    protected string $icon = 'new_comer.svg';

    /**
     * Check is user qualifies for badge
     */
    public function qualifier($user): bool
    {
        return $user->created_at->diffInMonths(now()) < 6;
    }
}
