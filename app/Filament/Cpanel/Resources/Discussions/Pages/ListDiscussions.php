<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Discussions\Pages;

use App\Filament\Cpanel\Resources\Discussions\DiscussionResource;
use Filament\Resources\Pages\ListRecords;

final class ListDiscussions extends ListRecords
{
    protected static string $resource = DiscussionResource::class;
}
