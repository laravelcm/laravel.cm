<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasLocaleScope
{
    public function scopeForLocale(Builder $query, ?string $locale): Builder
    {
        if ($locale) {
            return $query->where('locale', $locale);
        }

        return $query;
    }
}
