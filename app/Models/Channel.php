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
use Spatie\Translatable\HasTranslations;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property array $description
 * @property string $color
 * @property int | null $parent_id
 */
final class Channel extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'color',
    ];

    public array $translatable = ['description'];

    protected static function boot(): void
    {
        parent::boot();

        self::saving(function ($channel): void {
            if ($channel->parent_id) {
                if ($record = self::find($channel->parent_id)) {
                    if ($record->exists() && $record->parent_id) { // @phpstan-ignore-line
                        throw CannotAddChannelToChild::childChannelCannotBeParent($channel);
                    }
                }
            }
        });
    }

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
