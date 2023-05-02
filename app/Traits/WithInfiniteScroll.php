<?php

declare(strict_types=1);

namespace App\Traits;

use Livewire\WithPagination;

trait WithInfiniteScroll
{
    use WithPagination;

    public int $perPage = 10;

    public function loadMore(): void
    {
        $this->perPage += 10;
    }
}
