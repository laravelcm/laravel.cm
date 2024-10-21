<?php

declare(strict_types=1);

namespace App\Filament\Resources\DiscussionResource\Pages;

use App\Filament\Resources\DiscussionResource;
use Filament\Resources\Pages\ListRecords;

final class ListDiscussions extends ListRecords
{
    protected static string $resource = DiscussionResource::class;
}
