<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class AbstractFilter
{
    abstract public function filter(Builder $builder, string $value): Builder;

    public function mappings(): array
    {
        return [];
    }

    protected function resolveFilterValue(string $key): mixed
    {
        return Arr::get($this->mappings(), $key);
    }
}
