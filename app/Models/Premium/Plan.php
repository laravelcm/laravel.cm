<?php

declare(strict_types=1);

namespace App\Models\Premium;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\Plan as Model;

/**
 * @mixin IdeHelperPlan
 */
final class Plan extends Model
{
    use HasFactory;

    public function scopeDeveloper(Builder $query): Builder
    {
        return $query->where('type', PlanType::DEVELOPER->value);
    }

    public function scopeEnterprise(Builder $query): Builder
    {
        return $query->where('type', PlanType::ENTERPRISE->value);
    }
}
