<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class RepositoryData extends Data
{
    public function __construct(
        public string $name,
        public string $html_url,
        public int $stargazers_count = 0,
        public int $download = 0,
        public ?string $description = null,
    ) {}
}
