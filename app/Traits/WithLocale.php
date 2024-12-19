<?php

declare(strict_types=1);

namespace App\Traits;

trait WithLocale
{
    public ?string $locale = null;

    public function selectLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
