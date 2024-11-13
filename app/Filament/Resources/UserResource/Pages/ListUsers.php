<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Components\Tab;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    
    public function getTabs() : array
    {
        return [
          __('global.all') => Tab::make(__('global.all')),
          __('global.banned') => Tab::make(__('global.banned'))
            ->modifyQueryUsing(function ($query) {
                return $query->isBanned();
            }),
        __('global.unbanned') => Tab::make(__('global.unbanned'))
            ->modifyQueryUsing(function ($query) {
                return $query->isNotBanned();
            }),
        ];
    }
}