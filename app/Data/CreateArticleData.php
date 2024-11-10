<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class CreateArticleData extends Data
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $body,
        public string $canonical_url,
        public ?Carbon $published_at,
        public bool $is_draft = false,
    ) {}
}
