<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class ArticleData extends Data
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $body,
        public string $locale,
        public ?string $canonical_url = null,
        public ?Carbon $published_at = null,
        public ?Carbon $submitted_at = null,
    ) {}
}
