<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class CreateDiscussionData extends Data
{
    public function __construct(
        public string $title,
        public string $body,
        public array $tags = [],
    ) {}
}
