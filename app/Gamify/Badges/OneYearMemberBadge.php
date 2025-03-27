<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

final class OneYearMemberBadge extends BadgeType
{
    protected string $name = 'badges.one_year.title';
    protected string $description = 'badges.one_year.description';

    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user): bool
    {
        return $user->created_at->diffInYears(now()) >= 1;
    }
}
