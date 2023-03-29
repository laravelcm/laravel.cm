<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotAddChannelToChild;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperChannel
 */
class Channel extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'color',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var string[]
     */
    protected $withCount = [
        'threads',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($channel) {
            if ($channel->parent_id) {
                if ($record = self::find($channel->parent_id)) {
                    if ($record->exists() && $record->parent_id) {
                        throw CannotAddChannelToChild::childChannelCannotBeParent($channel);
                    }
                }
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class);
    }

    public function hasItems(): bool
    {
        return $this->items->isNotEmpty();
    }
}
