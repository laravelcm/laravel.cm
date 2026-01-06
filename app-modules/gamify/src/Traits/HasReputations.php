<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\Models\Reputation;
use Laravelcm\Gamify\PointType;
use Throwable;

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
            $pointType->payee()?->addPoint($pointType->getPoints());

            return true;
        }

        return false;
    }

    /**
     * Undo last given point for a subject model
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     * @throws Throwable
     */
    public function undoPoint(PointType $pointType): bool
    {
        if (! $pointType->reputationExists()) {
            return true;
        }

        $reputation = $pointType->firstReputation();
        $reputation->undo();

        return true;
    }

    /**
     * Reputations of user relation
     *
     * @return HasMany<User, $this>
     */
    public function reputations(): HasMany
    {
        return $this->hasMany(config('gamify.reputation_model'), 'payee_id'); // @phpstan-ignore-line
    }

    /**
     * Store a reputation for point
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

        $pointType->storeReputation($meta);

        return true;
    }

    /**
     * Give point to a user
     */
    public function addPoint(int $point = 1): static
    {
        $this->increment($this->getReputationField(), $point);

        return $this;
    }

    /**
     * Reduce a user point
     */
    public function reducePoint(int $point = 1): static
    {
        $this->decrement($this->getReputationField(), $point);

        return $this;
    }

    /**
     * Reset a user point to zero
     */
    public function resetPoint(): static
    {
        $this->forceFill([$this->getReputationField() => 0])->save();

        return $this;
    }

    /**
     * Get user reputation point
     */
    public function getPoints(bool $formatted = false): int|string
    {
        $point = $this->{$this->getReputationField()};

        return $formatted ? (string) Number::abbreviate($point) : (int) $point;
    }

    /**
     * Get the reputation column name
     */
    protected function getReputationField(): string
    {
        // @phpstan-ignore-next-line
        return property_exists($this, 'reputationColumn')
            ? $this->reputationColumn
            : 'reputation';
    }

    /**
     * Check for duplicate point allowed
     */
    protected function isDuplicatePointAllowed(PointType $pointType): bool
    {
        return property_exists($pointType, 'allowDuplicates')
            ? $pointType->allowDuplicates
            : config('gamify.allow_reputation_duplicate', true);
    }
}
