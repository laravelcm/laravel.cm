<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilters
{
    protected Builder $builder;

    protected array $filters = [];

    public function __construct(public Request $request)
    {
    }

    /**
     * Get all filters and make a new instance.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolverFilter($filter)->filter($builder, $value);
        }

        return $builder;
    }

    /**
     * Add Filters to current filter class.
     *
     * @param  array $filters
     * @return $this
     */
    public function add(array $filters): self
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    /**
     * Get the Filter instance Class.
     *
     * @param  $filter
     * @return mixed
     */
    public function resolverFilter($filter)
    {
        return new $this->filters[$filter];
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters(): array
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }
}
