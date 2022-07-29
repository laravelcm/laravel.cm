<?php

namespace App\Traits;

use App\Models\Tag;

trait WithTags
{
    public ?string $tag = null;

    public string $sortBy = 'recent';

    public function toggleTag($tag): void
    {
        $this->tag = $this->tag !== $tag && $this->tagExists($tag) ? $tag : null;
    }

    public function sortBy($sort): void
    {
        $this->sortBy = $this->validSort($sort) ? $sort : 'recent';
    }

    public function tagExists($tag): bool
    {
        return Tag::where('slug', $tag)->exists();
    }
}
