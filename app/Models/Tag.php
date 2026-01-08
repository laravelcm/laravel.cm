<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasPublicId;
use App\Models\Traits\HasSlug;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read ?string $description
 * @property-read array<string, mixed> $concerns
 * @property-read Collection<int, Article> $articles
 */
final class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    use HasPublicId;
    use HasSlug;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * @return MorphToMany<Article, $this, MorphPivot>
     */
    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    protected function casts(): array
    {
        return [
            'concerns' => 'array',
        ];
    }
}
