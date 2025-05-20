<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasLocaleScope
{
    /**
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    #[Scope]
    protected function forLocale(Builder $query, ?string $locale): Builder
    {
        if (filled($locale)) {
            return $query->where('locale', $locale);
        }

        return $query;
    }
}
