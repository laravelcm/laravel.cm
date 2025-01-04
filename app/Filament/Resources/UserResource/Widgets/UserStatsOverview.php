<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

final class UserStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Account';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::query()->count())
                ->chart(
                    Trend::query(User::query())
                        ->between(
                            start: now()->startOfWeek(),
                            end: now()->endOfWeek(),
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
                ->description('Total number of accounts')
                ->icon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Account created this week', User::query()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count())
                ->chart(
                    Trend::query(User::query())
                        ->between(
                            start: now()->startOfWeek(),
                            end: now()->endOfWeek(),
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
                ->description('Total number of accounts created this week')
                ->icon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Verified Users', User::VerifiedUsers()->count())
                ->chart(
                    Trend::query(User::VerifiedUsers())
                        ->between(
                            start: now()->subMonths(3),
                            end: now(),
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
                ->description('Total number of accounts verified')
                ->icon('heroicon-o-check-badge')
                ->color('primary'),

            Stat::make('Unverified Users', User::UnVerifiedUsers()->count())
                ->chart(
                    Trend::query(User::UnVerifiedUsers())
                        ->between(
                            start: now()->subMonths(3),
                            end: now(),
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
                ->description('Total number of accounts unverified')
                ->icon('heroicon-o-x-mark')
                ->color('warning'),
        ];
    }
}
