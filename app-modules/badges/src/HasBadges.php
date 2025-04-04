<?php

declare(strict_types=1);

namespace Laravelcm\Badges;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravelcm\Badges\Badge> $badges
 * @property-read int|null $badges_count
 */
trait HasBadges
{
    /**
     * Badges user relation
     *
     * @return mixed
     */
    public function badges()
    {
        return $this->belongsToMany(config('gamify.badge_model'), 'user_badges')
            ->withTimestamps();
    }

    /**
     * Sync badges for qiven user
     */
    public function syncBadges($user = null): void
    {
        $user = is_null($user) ? $this : $user;

        $badgeIds = app('badges')->filter
            ->qualifier($user)
            ->map->getBadgeId();

        $user->badges()->sync($badgeIds);
    }
}
