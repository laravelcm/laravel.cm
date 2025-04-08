<?php

declare(strict_types=1);

namespace Laravelcm\Badges;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravelcm\Gamify\Models\Reputation;

/**
 * @property-read Collection<int, Reputation> $reputations
 * @property-read int|null $reputations_count
 */
trait HasReputations
{
    /**
     * Give reputation point to payee
     *
     * @return bool
     */
    public function givePoint(PointType $pointType): bool
    {
        if (! $pointType->qualifier()) {
            return false;
        }

        if ($this->storeReputation($pointType)) {
            return $pointType->payee()->addPoint($pointType->getPoints());
        }
    }

    /**
     * Undo last given point for a subject model
     *
     * @return bool
     */
    public function undoPoint(PointType $pointType): bool
    {
        $reputation = $pointType->firstReputation();

        if (! $reputation) {
            return false;
        }

        // undo reputation
        $reputation->undo();
    }

    /**
     * Reputations of user relation
     *
     * @return HasMany
     */
    public function reputations(): HasMany
    {
        return $this->hasMany(config('gamify.reputation_model'), 'payee_id');
    }

    /**
     * Store a reputation for point
     *
     * @return mixed
     */
    public function storeReputation(PointType $pointType, array $meta = [])
    {
        if (! $this->isDuplicatePointAllowed($pointType) && $pointType->reputationExists()) {
            return false;
        }

        return $pointType->storeReputation($meta);
    }

    /**
     * Give point to a user
     *
     * @param  int  $point
     * @return HasReputations
     */
    public function addPoint($point = 1)
    {
        $this->increment($this->getReputationField(), $point);

        return $this;
    }

    /**
     * Reduce a user point
     *
     * @param  int  $point
     * @return HasReputations
     */
    public function reducePoint($point = 1)
    {
        $this->decrement($this->getReputationField(), $point);

        return $this;
    }

    /**
     * Reset a user point to zero
     *
     * @return mixed
     */
    public function resetPoint()
    {
        $this->forceFill([$this->getReputationField() => 0])->save();

        return $this;
    }

    /**
     * Get user reputation point
     *
     * @param  bool  $formatted
     * @return int|string
     */
    public function getPoints($formatted = false)
    {
        $point = $this->{$this->getReputationField()};

        if ($formatted) {
            return short_number($point);
        }

        return (int) $point;
    }

    /**
     * Get the reputation column name
     *
     * @return string
     */
    protected function getReputationField()
    {
        return property_exists($this, 'reputationColumn')
            ? $this->reputationColumn
            : 'reputation';
    }

    /**
     * Check for duplicate point allowed
     *
     * @return bool
     */
    protected function isDuplicatePointAllowed(PointType $pointType)
    {
        return property_exists($pointType, 'allowDuplicates')
            ? $pointType->allowDuplicates
            : config('gamify.allow_reputation_duplicate', true);
    }
}
