<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravelcm\Sentinel\Models\ContentIssue;

trait HasContentIssues
{
    /**
     * @return MorphMany<ContentIssue, $this>
     */
    public function contentIssues(): MorphMany
    {
        return $this->morphMany(ContentIssue::class, 'issueable');
    }

    public function sentinelContent(): string
    {
        return (string) $this->{$this->sentinelContentColumn()};
    }

    public function sentinelContentColumn(): string
    {
        return 'body';
    }

    public function sentinelCanonicalUrl(): ?string
    {
        return null;
    }
}
