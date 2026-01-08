<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanType;
use App\Models\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Laravelcm\Subscriptions\Models\Plan as Model;

/**
 * @property-read PlanType $type
 *
 * @mixin Model
 */
final class Plan extends Model
{
    use HasPublicId;

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
        $query->where('type', PlanType::DEVELOPER);
    }

    /**
     * @param  Builder<Plan>  $query
     */
    #[Scope]
    protected function enterprise(Builder $query): void
    {
        $query->where('type', PlanType::ENTERPRISE);
    }
}
