<?php

namespace App\Http\Resources;

class EnterpriseResourceCollection extends PaginationResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->transform(fn ($enterprise) => new EnterpriseResource($enterprise)),
            'pagination' => $this->pagination,
            'filters' => $this->filters,
        ];
    }
}
