<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

final class TwoYearMemberBadge extends BadgeType
{
    protected string $name = 'badges.two_year.title';
    protected string $description = 'badges.two_year.description';

    /**
     * Check is user qualifies for badge
     * @param $user
     * @return bool
     */
    public function qualifier($user): bool
    {
        return $user->created_at->diffInYears(now()) >= 2;
    }
}
