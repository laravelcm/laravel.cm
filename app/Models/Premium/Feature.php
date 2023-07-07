<?php

declare(strict_types=1);

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\PlanFeature as Model;

/**
 * @mixin IdeHelperFeature
 */
final class Feature extends Model
{
    use HasFactory;
}
