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
          __('global.ban.all') => Tab::make(__('global.ban.all')),
          __('global.ban.banned') => Tab::make(__('global.ban.banned'))
            ->modifyQueryUsing(function ($query) {
                return $query->isBanned();
            }),
        __('global.ban.not_banned') => Tab::make(__('global.ban.not_banned'))
            ->modifyQueryUsing(function ($query) {
                return $query->isNotBanned();
            }),
        ];
    }
}