<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Channels\Pages;

use App\Filament\Cpanel\Resources\Channels\ChannelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

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
