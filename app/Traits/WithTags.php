<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Tag;

trait WithTags
{
    public ?string $tag = null;

    public string $sortBy = 'recent';

    public function toggleTag(string $tag): void
    {
        $this->tag = $this->tag !== $tag && $this->tagExists($tag) ? $tag : null;
    }

    public function sortBy(string $sort): void
    {
        $this->sortBy = $this->validSort($sort) ? $sort : 'recent';
    }

    public function tagExists(string $tag): bool
    {
        return Tag::where('slug', $tag)->exists();
    }
}
