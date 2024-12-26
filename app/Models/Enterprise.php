<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\Enterprise\EnterpriseFilters;
use App\Models\Traits\HasSlug;
use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Enterprise extends Model implements HasMedia
{
    use HasFactory;
    use HasSettings;
    use HasSlug;
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
        'user_id',
        'settings',
    ];

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

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('logo_thumb')
            ->format('webp')
            ->performOnCollections('logo')
            ->nonQueued();
        $this->addMediaConversion('cover_thumb')
            ->format('webp')
            ->performOnCollections('cover')
            ->nonQueued();
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

    /**
     * @param  Builder<Enterprise>  $query
     * @param  string[]  $filters
     */
    public function scopeFilters(Builder $query, Request $request, array $filters = []): Builder
    {
        return (new EnterpriseFilters($request))->add($filters)->filter($query);
    }
}
