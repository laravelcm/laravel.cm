<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

final class VeteranBadge extends BadgeType
{
    protected string $name = 'badges.veteran.title';
    protected string $description = 'badges.veteran.description';

    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user): bool
    {
        return $user->created_at->diffInYears(now()) > 4;
    }
}
