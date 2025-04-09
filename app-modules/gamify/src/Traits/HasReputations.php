<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\Models\Reputation;
use Laravelcm\Gamify\PointType;

/**
 * @property-read Collection<int, Reputation> $reputations
 * @property-read int|null $reputations_count
 */
trait HasReputations
{
    /**
     * Give reputation point to payee
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
     * @throws InvalidPayeeModelException
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
     */
    public function reputations(): HasMany
    {
        return $this->hasMany(config('gamify.reputation_model'), 'payee_id');
    }

    /**
     * Store a reputation for point
     *
     * @return mixed
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     * @throws PointsNotDefinedException
     */
    public function storeReputation(PointType $pointType, array $meta = []): bool
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
    public function resetPoint(): mixed
    {
        $this->forceFill([$this->getReputationField() => 0])->save();

        return $this;
    }

    /**
     * Get user reputation point
     *
     * @param bool $formatted
     * @return int|string
     */
    public function getPoints(bool $formatted = false): int|string
    {
        $point = $this->{$this->getReputationField()};

        if ($formatted) {
            return Str::numbers($point);
        }

        return (int) $point;
    }

    /**
     * Get the reputation column name
     *
     * @return string
     */
    protected function getReputationField(): string
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
    protected function isDuplicatePointAllowed(PointType $pointType): bool
    {
        return property_exists($pointType, 'allowDuplicates')
            ? $pointType->allowDuplicates
            : config('gamify.allow_reputation_duplicate', true);
    }
}
