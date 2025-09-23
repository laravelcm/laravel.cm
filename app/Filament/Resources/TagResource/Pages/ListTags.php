<?php

declare(strict_types=1);

namespace App\Filament\Resources\TagResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Support\Enums\Width;
use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth(Width::Large),
        ];
    }
}
