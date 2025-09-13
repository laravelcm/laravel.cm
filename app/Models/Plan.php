<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Laravelcm\Subscriptions\Models\Plan as Model;

/**
 * @mixin Model
 *
 * @property-read PlanType $type
 */
final class Plan extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => PlanType::class,
        ];
    }

    /**
     * @param  Builder<Plan>  $query
     */
    #[Scope]
    protected function developer(Builder $query): void
    {
        $query->where('type', PlanType::DEVELOPER->value);
    }

    /**
     * @param  Builder<Plan>  $query
     */
    #[Scope]
    protected function enterprise(Builder $query): void
    {
        $query->where('type', PlanType::ENTERPRISE->value);
    }
}
