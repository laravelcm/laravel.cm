<?php

declare(strict_types=1);

namespace App\Filament\Resources\Threads\Pages;

use App\Filament\Resources\Threads\ThreadResource;
use Filament\Resources\Pages\ListRecords;

final class ListThreads extends ListRecords
{
    protected static string $resource = ThreadResource::class;
}
