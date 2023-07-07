<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    /**
     * @param int[] $tags
     */
    public function syncTags(array $tags): void
    {
        $this->save();
        $this->tags()->sync($tags);

        $this->unsetRelation('tags');
    }

    public function removeTags(): void
    {
        $this->tags()->detach();

        $this->unsetRelation('tags');
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas('tags', function ($query) use ($tag): void {
            $query->where('tags.slug', $tag);
        });
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
