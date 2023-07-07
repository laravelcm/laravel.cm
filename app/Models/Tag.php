<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin IdeHelperTag
 */
final class Tag extends Model
{
    use HasFactory;
    use HasSlug;
    use ModelHelpers;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'concerns',
    ];

    protected $casts = [
        'concerns' => 'array',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
