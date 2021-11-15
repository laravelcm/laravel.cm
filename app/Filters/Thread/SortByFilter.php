<?php

namespace App\Filters\Thread;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class SortByFilter extends AbstractFilter
{
    public function mappings(): array
    {
        return [
            'recent' => 'recent',
            'resolved' => 'resolved',
            'unresolved' => 'unresolved',
        ];
    }

    public function filter(Builder $builder, $value): Builder
    {
        $value = $this->resolveFilterValue($value);

        switch ($value) {
            case null:
                return $builder;
            case 'recent':
                return $builder->recent();
            case 'resolved':
                return $builder->resolved();
            case 'unresolved':
                return $builder->unresolved();
        }
    }
}
