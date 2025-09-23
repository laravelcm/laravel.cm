<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChannelResource\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use Filament\Support\Enums\Width;
use App\Filament\Resources\ChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListChannels extends ListRecords
{
    use Translatable;

    protected static string $resource = ChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make()
                ->slideOver()
                ->modalWidth(Width::Large),
        ];
    }
}
