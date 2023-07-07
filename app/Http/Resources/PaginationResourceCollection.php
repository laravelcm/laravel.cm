<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class PaginationResourceCollection extends ResourceCollection
{
    public function __construct($resource, public $filters = [])
    {
        $this->pagination = [
            'total' => $resource->total(),
            'perPage' => $resource->perPage(),
            'currentPage' => $resource->currentPage(),
            'nextPage' => $resource->nextPageUrl(),
            'prevPage' => $resource->previousPageUrl(),
            'firstPage' => $resource->url(1),
            'lastPage' => $resource->url($resource->lastPage()),
            'from' => $resource->firstItem(),
            'to' => $resource->lastItem(),
            'totalPages' => $resource->lastPage(),
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
}
