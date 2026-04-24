<?php

declare(strict_types=1);

namespace App\Console\Commands\Content\Data;

final readonly class AttackerReport
{
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public ?string $bannedAt,
        public int $pollutedCount,
        public string $tables,
    ) {}
}
