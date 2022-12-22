<?php

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage as Model;

/**
 * @mixin IdeHelperSubscriptionUsage
 */
class SubscriptionUsage extends Model
{
    use HasFactory;
}
