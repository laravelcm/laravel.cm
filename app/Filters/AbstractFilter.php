<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class AbstractFilter
{
    abstract public function filter(Builder $builder, $value): Builder;

    public function mappings(): array
    {
        return [];
    }

    protected function resolveFilterValue($key): mixed
    {
        return Arr::get($this->mappings(), $key);
    }
}
