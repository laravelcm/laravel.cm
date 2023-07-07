<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LaravelFeature\Model\Feature as Model;

/**
 * @mixin IdeHelperFeature
 */
final class Feature extends Model
{
    use HasFactory;

    protected $guarded = [];
}
