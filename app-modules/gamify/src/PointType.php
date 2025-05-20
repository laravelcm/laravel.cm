<?php

declare(strict_types=1);

namespace Laravelcm\Gamify;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\Models\Reputation;

/**
 * @property string $name
 * @property int $points
 * @property Authenticatable|string|null $payer
 */
abstract class PointType
{
    /**
     * @var Model|null
     */
    protected $subject;

    /**
     * Check qualification to give this point
     */
    public function qualifier(): bool
    {
        return true;
    }

    /**
     * Payee who will be receiving points
     *
     * @throws PointSubjectNotSetException
     */
    public function payee(): ?User
    {
        if (property_exists($this, 'payee')) {
            return $this->getSubject()->{$this->payee};
        }

        return null;
    }

    /**
     * Subject model for point
     *
     * @throws PointSubjectNotSetException
     */
    public function getSubject(): Model
    {
        if (blank($this->subject)) {
            throw new PointSubjectNotSetException;
        }

        return $this->subject;
    }

    /**
     * Get point name
     */
    public function getName(): string
    {
        return property_exists($this, 'name')
            ? $this->name
            : class_basename($this);
    }

    /**
     * Get points
     *
     * @throws PointsNotDefinedException
     */
    public function getPoints(): int
    {
        // @phpstan-ignore-next-line
        if (blank($this->points)) {
            throw new PointsNotDefinedException;
        }

        return $this->points;
    }

    /**
     * Set a subject
     */
    public function setSubject(Model $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * Check if reputation already exists for a point
     *
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    public function reputationExists(): bool
    {
        return $this->reputationQuery()->exists();
    }

    /**
     * Get first reputation for point
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    public function firstReputation(): Reputation
    {
        return $this->reputationQuery()->first(); // @phpstan-ignore-line
    }

    /**
     * Store a reputation in the database
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     * @throws PointsNotDefinedException
     */
    public function storeReputation(array $meta): Reputation
    {
        // @phpstan-ignore-next-line
        return $this->payeeReputations()->create([
            'payee_id' => $this->payee()?->id,
            'subject_type' => $this->getSubject()->getMorphClass(),
            'subject_id' => $this->getSubject()->getKey(),
            'name' => $this->getName(),
            'meta' => json_encode($meta),
            'point' => $this->getPoints(),
        ]);
    }

    /**
     * Get reputation query for this point
     *
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    public function reputationQuery(): HasMany
    {
        return $this->payeeReputations()->where([
            ['payee_id', $this->payee()?->id],
            ['subject_type', $this->getSubject()->getMorphClass()],
            ['subject_id', $this->getSubject()->getKey()],
            ['name', $this->getName()],
        ]);
    }

    /**
     * Return reputations payee relation
     *
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    protected function payeeReputations(): HasMany
    {
        $model = $this->payee();

        if (! $model instanceof Authenticatable) {
            throw new InvalidPayeeModelException;
        }

        return $model->reputations();
    }
}
