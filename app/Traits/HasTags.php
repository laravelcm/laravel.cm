<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function syncTags(array $tags)
    {
        $this->save();
        $this->tags()->sync($tags);

        $this->unsetRelation('tags');
    }

    public function removeTags()
    {
        $this->tags()->detach();

        $this->unsetRelation('tags');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
