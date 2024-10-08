<?php

declare(strict_types=1);

namespace App\Data\Article;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class CreateArticleData extends Data
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $body,
        public Carbon $published_at,
        public ?Carbon $submitted_at,
        public ?Carbon $approved_at,
        public string $show_toc,
        public string $canonical_url,
        public array $associateTags = [],
    ) {}
}
