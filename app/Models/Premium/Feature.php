<?php

namespace App\Models\Premium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Models\PlanFeature as Model;

/**
 * @mixin IdeHelperFeature
 */
class Feature extends Model
{
    use HasFactory;
}
