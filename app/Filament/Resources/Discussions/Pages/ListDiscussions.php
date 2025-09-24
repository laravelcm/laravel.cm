<?php

declare(strict_types=1);

namespace App\Filament\Resources\Discussions\Pages;

use App\Filament\Resources\Discussions\DiscussionResource;
use Filament\Resources\Pages\ListRecords;

final class ListDiscussions extends ListRecords
{
    protected static string $resource = DiscussionResource::class;
}
