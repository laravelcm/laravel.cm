<?php

declare(strict_types=1);

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\PlanSubscription as Model;

/**
 * @mixin IdeHelperSubscription
 */
final class Subscription extends Model
{
    use HasFactory;
}
