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
          __('Tout') => Tab::make('Tout'),
          __("Bannis") => Tab::make(__('Bannis'))
            ->modifyQueryUsing(function ($query) {
                return $query->isBanned();
            }),
        __("Non Bannis") => Tab::make(__('Non Bannis'))
            ->modifyQueryUsing(function ($query) {
                return $query->isNotBanned();
            }),
        ];
    }
}