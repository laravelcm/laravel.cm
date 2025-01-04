<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

final class ArticleStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected ?string $heading = 'Posts';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        return [
            Stat::make('Total Post', Article::query()->published()->count())
                ->icon('heroicon-o-newspaper')
                ->chart(
                    Trend::query(Article::query()->published())
                        ->between(
                            start: $currentWeekStart,
                            end: $currentWeekEnd,
                        )->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)->toArray()
                )->description(__('Total Post')),

            Stat::make(
                'Recent post',
                Article::query()
                    ->recent()
                    ->whereBetween('created_at', [
                        $currentWeekStart,
                        $currentWeekEnd,
                    ])->count()
            )
                ->chart(
                    Trend::query(Article::query())
                        ->between(
                            start: $currentWeekStart,
                            end: $currentWeekEnd,
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )->icon('heroicon-o-newspaper')
                ->color('primary')
                ->description('Total Posts of the week'),
        ];
    }
}
