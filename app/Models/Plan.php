<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Builder;
use Laravelcm\Subscriptions\Models\Plan as Model;

final class Plan extends Model
{
    public function scopeDeveloper(Builder $query): Builder
    {
        return $query->where('type', PlanType::DEVELOPER->value);
    }

    public function scopeEnterprise(Builder $query): Builder
    {
        return $query->where('type', PlanType::ENTERPRISE->value);
    }
}
