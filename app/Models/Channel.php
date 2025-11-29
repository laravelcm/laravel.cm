<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotAddChannelToChild;
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
 * @property-read string $name
 * @property-read string $slug
 * @property-read string|null $description
 * @property-read string $color
 * @property-read int|null $parent_id
 * @property-read Channel|null $parent
 * @property-read Collection<array-key, Channel> $items
 * @property-read Collection<array-key, Thread> $threads
 */
final class Channel extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['description'];

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
}
