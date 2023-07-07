<?php

declare(strict_types=1);

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage as Model;

/**
 * @mixin IdeHelperSubscriptionUsage
 */
final class SubscriptionUsage extends Model
{
    use HasFactory;
}
