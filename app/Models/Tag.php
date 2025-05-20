<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string|null $description
 * @property-read array $concerns
 * @property-read \Illuminate\Support\Collection<array-key, Article> $articles
 */
final class Tag extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'concerns' => 'array',
        ];
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
