<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

final class UserActivityWidget extends ChartWidget
{
    protected static ?string $heading = 'Most active users this week';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $users = User::with('activities')
            ->withCount('activities')
            ->verifiedUsers()
            ->whereHas('activities', fn (Builder $query) => $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]))
            ->orderByDesc('activities_count')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Activities',
                    'data' => $users->pluck('activities_count')->toArray(),
                ],
            ],
            'labels' => $users->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
