<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

final class UserChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Création de compte';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    public ?string $filter = 'week';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getFilters(): array
    {
        return [
            'week' => 'Last Week',
            'month' => 'Last Month',
            '3months' => 'Last 3 Months',
        ];
    }

    protected function getData(): array
    {
        match ($this->filter) { // @phpstan-ignore-line
            'week' => $data = Trend::model(User::class)
                ->between(
                    start: now()->subWeeks(),
                    end: now()
                )
                ->perDay()
                ->count(),

            'month' => $data = Trend::model(User::class)
                ->between(
                    start: now()->subMonth(),
                    end: now()
                )
                ->perDay()
                ->count(),

            '3months' => $data = Trend::model(User::class)
                ->between(
                    start: now()->subMonths(3),
                    end: now()
                )
                ->perMonth()
                ->count(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'Compte créé',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate), // @phpstan-ignore-line
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date), // @phpstan-ignore-line
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
