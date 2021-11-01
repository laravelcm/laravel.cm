<?php

namespace App\Traits;

use Livewire\WithPagination;

trait WithInfiniteScroll
{
    use WithPagination;

    public int $perPage = 10;

    public function loadMore()
    {
        $this->perPage += 10;
    }
}
