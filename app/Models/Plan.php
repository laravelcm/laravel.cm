<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Laravelcm\Subscriptions\Models\Plan as Model;

final class Plan extends Model
{
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
