<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BlogPostsOverview;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected function getWidgets(): array
    {
        return [
            BlogPostsOverview::class,
        ];
    }

    protected function getColumns(): int|array
    {
        return 5;
    }
}
