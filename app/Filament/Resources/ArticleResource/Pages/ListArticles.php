<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Closure;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

final class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    public function isTableRecordSelectable(): Closure
    {
        return fn (Article $record): bool => $record->isNotPublished();
    }

    public function getTabs(): array
    {
        return [
            'En attente' => Tab::make()->query(fn ($query) => $query->awaitingApproval()),
            'Apprové' => Tab::make()->query(fn ($query) => $query->published()),
            'Décliné' => Tab::make()->query(fn ($query) => $query->declined()),
        ];
    }
}
