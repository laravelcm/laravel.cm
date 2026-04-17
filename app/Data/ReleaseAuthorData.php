<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class ReleaseAuthorData extends Data
{
    public function __construct(
        public string $login,
        public string $avatar_url,
        public string $html_url,
    ) {}
}
