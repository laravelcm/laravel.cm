<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

trait RecordsActivity
{
    /**
     * @return MorphMany<Activity, $this>
     */
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected static function bootRecordsActivity(): void
    {
        if (Auth::guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event): void {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model): void {
            $model->activities()->delete();
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
     * @param  array<string, mixed>  $data
     */
    protected function recordActivity(string $event, bool $useDefaultEvent = true, array $data = []): void
    {
        $this->activities()->create([
            'user_id' => Auth::id(),
            'type' => $useDefaultEvent ? $this->getActivityType($event) : $event,
            'data' => $data,
        ]);
    }

    protected function getActivityType(string $event): string
    {
        $type = mb_strtolower(new ReflectionClass($this)->getShortName());

        return sprintf('%s_%s', $event, $type);
    }
}
