<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\Enterprise\EnterpriseFilters;
use App\Models\Traits\HasPublicId;
use App\Models\Traits\HasSlug;
use App\Traits\HasSettings;
use Database\Factories\EnterpriseFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property-read int $id
 * @property-read string $public_id
 * @property-read bool $is_public
 * @property-read bool $is_certified
 * @property-read bool $is_featured
 * @property-read array<string, mixed>|null $settings
 */
final class Enterprise extends Model implements HasMedia
{
    /** @use HasFactory<EnterpriseFactory> */
    use HasFactory;

    use HasPublicId;
    use HasSettings;
    use HasSlug;
    use InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpg',
                'image/png',
                'image/svg',
                'image/gif',
                'image/webp',
            ]);

        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpg',
                'image/png',
                'image/webp',
            ]);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_public' => 'boolean',
            'is_certified' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Enterprise>  $query
     */
    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * @param  Builder<Enterprise>  $query
     */
    #[Scope]
    protected function certified(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * @param  Builder<Enterprise>  $query
     */
    #[Scope]
    protected function public(Builder $query): void
    {
        $query->where('is_public', true);
    }

    /**
     * @param  Builder<Enterprise>  $query
     * @param  string[]  $filters
     */
    #[Scope]
    protected function filters(Builder $query, Request $request, array $filters = []): Builder
    {
        return new EnterpriseFilters($request)->add($filters)->filter($query);
    }
}
