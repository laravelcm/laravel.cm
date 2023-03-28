<?php

declare(strict_types=1);

namespace App\Filters\Thread;

use App\Filters\AbstractFilters;

class ThreadFilters extends AbstractFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = [
        'sortBy' => SortByFilter::class,
    ];
}
