<?php

declare(strict_types=1);

namespace App\Filament\Resources\ThreadResource\Pages;

use App\Filament\Resources\ThreadResource;
use Filament\Resources\Pages\ListRecords;

final class ListThreads extends ListRecords
{
    protected static string $resource = ThreadResource::class;
}
