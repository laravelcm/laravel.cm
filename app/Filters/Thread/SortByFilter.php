<?php

declare(strict_types=1);

namespace App\Filters\Thread;

use App\Filters\AbstractFilter;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;

final class SortByFilter extends AbstractFilter
{
    public function mappings(): array
    {
        return [
            'recent' => 'recent',
            'resolved' => 'resolved',
            'unresolved' => 'unresolved',
        ];
    }

    /**
     * @param  Builder<Thread>  $builder
     * @param  mixed  $value
     * @return Builder<Thread>
     */
    public function filter(Builder $builder, mixed $value): Builder
    {
        $value = $this->resolveFilterValue($value);

        return match ($value) {
            'recent' => $builder->recent(),
            'resolved' => $builder->resolved(),
            'unresolved' => $builder->unresolved(),
            default => $builder,
        };
    }
}
