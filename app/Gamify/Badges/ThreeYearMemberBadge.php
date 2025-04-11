<?php

declare(strict_types=1);

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

final class ThreeYearMemberBadge extends BadgeType
{
    protected string $name = 'badges.three_year.title';

    protected string $description = 'badges.three_year.description';

    /**
     * Check is user qualifies for badge
     */
    public function qualifier($user): bool
    {
        return $user->created_at->diffInYears(now()) >= 3;
    }
}
