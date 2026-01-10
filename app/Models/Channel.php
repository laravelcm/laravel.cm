<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotAddChannelToChild;
use App\Models\Traits\HasPublicId;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

/**
 * @property-read int $id
 * @property-read string $public_id
 * @property-read string $name
 * @property-read string $slug
 * @property-read ?string $description
 * @property-read string $color
 * @property-read ?int $parent_id
 * @property-read ?Channel $parent
 * @property-read Collection<int, Channel> $items
 * @property-read Collection<int, Thread> $threads
 */
final class Channel extends Model
{
    use HasFactory;
    use HasPublicId;
    use HasSlug;
    use HasTranslations;

    public array $translatable = [
        'description',
    ];

    protected $guarded = [];

    public function getLocale(): string
    {
        return app()->getLocale() ?? config('app.fallback_locale', 'fr');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function hasItems(): bool
    {
        return $this->items->isNotEmpty();
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<self, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsToMany<Thread, $this, Pivot>
     */
    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        self::saving(function (self $channel): void {
            /** @var self $record */
            $record = self::query()->find($channel->parent_id);

            if ($channel->parent_id && $record->exists() && $record->parent_id) {
                throw CannotAddChannelToChild::childChannelCannotBeParent($channel);
            }
        });
    }
}
