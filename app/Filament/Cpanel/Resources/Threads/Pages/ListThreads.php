<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Threads\Pages;

use App\Filament\Cpanel\Resources\Threads\ThreadResource;
use Filament\Resources\Pages\ListRecords;

final class ListThreads extends ListRecords
{
    protected static string $resource = ThreadResource::class;
}
