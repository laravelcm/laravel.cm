<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use ReflectionClass;

trait RecordsActivity
{
    protected static function bootRecordsActivity(): void
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event): void {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model): void {
            $model->activity()->delete();
        });
    }

    /**
     * @return string[]
     */
    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    /**
     * @param string $event
     * @param bool $useDefaultEvent
     * @param array<string, mixed> $data
     * @return void
     */
    protected function recordActivity(string $event, bool $useDefaultEvent = true, array $data = []): void
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $useDefaultEvent ? $this->getActivityType($event) : $event,
            'data' => $data,
        ]);
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType(string $event): string
    {
        $type = mb_strtolower((new ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
