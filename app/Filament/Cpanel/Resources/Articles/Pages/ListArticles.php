<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Articles\Pages;

use App\Filament\Cpanel\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\ListRecords;

final class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;
}
