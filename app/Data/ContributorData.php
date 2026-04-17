<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class ContributorData extends Data
{
    public function __construct(
        public string $login,
        public string $avatar,
    ) {}

    public function profileUrl(): string
    {
        return 'https://github.com/'.$this->login;
    }
}
