<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('global.all')),
            'banned' => Tab::make(__('global.banned'))
                ->modifyQueryUsing(fn ($query) => $query->isBanned()),
        ];
    }
}
