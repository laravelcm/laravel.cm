<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Widgets;

use App\Models\Article;
use CyrildeWit\EloquentViewable\Support\Period;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

final class MostViewedPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Article le plus vu cette semaine';

    protected static ?string $maxHeight = '200px';

    protected int|string|array $columnSpan = 'full';

    protected int $titleLength = 10;

    protected function getData(): array
    {
        $articles = Article::withViewsCount(Period::create(now()->startOfWeek(), now()->endOfWeek())) // @phpstan-ignore-line
            ->published()
            ->orderByDesc('views_count')
            ->orderByDesc('published_at')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Article le plus vu',
                    'data' => $articles->pluck('views_count')->toArray(),
                ],
            ],
            'labels' => $articles->pluck('title')
                ->map(fn ($title) => Str::limit($title, $this->titleLength, '...'))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
