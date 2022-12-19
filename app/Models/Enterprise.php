<?php

namespace App\Models;

use App\Traits\HasSettings;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperEnterprise
 */
class Enterprise extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasSettings;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'website',
        'about',
        'address',
        'description',
        'founded_in',
        'ceo',
        'is_featured',
        'is_certified',
        'is_public',
        'size',
        'settings',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'is_public' => 'boolean',
        'is_certified' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/svg']);

        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeCertified(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}
