<?php

declare(strict_types=1);

namespace App\Filters\Thread;

use App\Filters\AbstractFilters;

final class ThreadFilters extends AbstractFilters
{
    protected array $filters = [
        'sortBy' => SortByFilter::class,
    ];
}
