<?php

declare(strict_types=1);

namespace Laravelcm\Gamify;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\Models\Reputation;

abstract class PointType
{
    /**
     * Subject for reputation
     *
     * @var Model
     */
    protected Model $subject;

    /**
     * Check qualification to give this point
     *
     * @return bool
     */
    public function qualifier(): bool
    {
        return true;
    }

    /**
     * Payee who will be receiving points
     *
     * @return Model
     * @throws PointSubjectNotSetException
     * @throws InvalidPayeeModelException
     */
    public function payee(): Model
    {
        if (property_exists($this, 'payee')) {
            return $this->getSubject()->{$this->payee};
        }

        throw new InvalidPayeeModelException;
    }

    /**
     * Subject model for point
     *
     * @return Model
     * @throws PointSubjectNotSetException
     */
    public function getSubject(): Model
    {
        if (! isset($this->subject)) {
            throw new PointSubjectNotSetException;
        }

        return $this->subject;
    }

    /**
     * Get point name
     *
     * @return string
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
     * @return int
     *
     * @throws PointsNotDefinedException
     */
    public function getPoints(): int
    {
        if (! isset($this->points)) {
            throw new PointsNotDefinedException;
        }

        return $this->points;
    }

    /**
     * Set a subject
     *
     * @param  mixed  $subject
     */
    public function setSubject(mixed $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * Check if reputation already exists for a point
     *
     * @return bool
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
     * @return Model
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    public function firstReputation(): Model
    {
        return $this->reputationQuery()->first();
    }

    /**
     * Store a reputation in the database
     *
     * @param array $meta
     * @return mixed
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     * @throws PointsNotDefinedException
     */
    public function storeReputation(array $meta): Reputation
    {
        return $this->payeeReputations()->create([
            'payee_id' => $this->payee()->id,
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
     * @return HasMany
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    public function reputationQuery(): HasMany
    {
        return $this->payeeReputations()->where([
            ['payee_id', $this->payee()->id],
            ['subject_type', $this->getSubject()->getMorphClass()],
            ['subject_id', $this->getSubject()->getKey()],
            ['name', $this->getName()],
        ]);
    }

    /**
     * Return reputations payee relation
     *
     * @return HasMany<User>
     *
     * @throws InvalidPayeeModelException
     * @throws PointSubjectNotSetException
     */
    protected function payeeReputations(): HasMany
    {
        $model = $this->payee();

        if (! $model) {
            throw new InvalidPayeeModelException;
        }

        return $model->reputations();
    }
}
