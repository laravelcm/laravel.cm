<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Scannable
{
    public function sentinelContent(): string;

    public function sentinelContentColumn(): string;

    public function sentinelCanonicalUrl(): ?string;

    public function contentIssues(): MorphMany;
}
