<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Tags\Pages;

use App\Filament\Cpanel\Resources\Tags\TagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

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
