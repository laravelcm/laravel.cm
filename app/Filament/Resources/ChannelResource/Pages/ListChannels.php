<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChannelResource\Pages;

use App\Filament\Resources\ChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

final class ListChannels extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth(MaxWidth::Large),
        ];
    }
}
