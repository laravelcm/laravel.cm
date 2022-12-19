<?php

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\Plan as Model;

/**
 * @mixin IdeHelperPlan
 */
class Plan extends Model
{
    use HasFactory;

    public function scopeDeveloper(Builder $query): Builder
    {
        return $query->where('type', \App\Enums\PlanType::DEVELOPER);
    }

    public function scopeEnterprise(Builder $query): Builder
    {
        return $query->where('type', \App\Enums\PlanType::ENTERPRISE);
    }
}
