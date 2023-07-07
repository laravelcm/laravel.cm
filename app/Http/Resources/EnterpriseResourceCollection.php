<?php

declare(strict_types=1);

namespace App\Http\Resources;

final class EnterpriseResourceCollection extends PaginationResourceCollection
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
