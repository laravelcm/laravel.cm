<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin IdeHelperTag
 */
class Tag extends Model
{
    use HasFactory,
        HasSlug,
        ModelHelpers;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'concerns',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
