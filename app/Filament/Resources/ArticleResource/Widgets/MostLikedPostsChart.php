<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

final class MostLikedPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Article le plus aimé';

    protected static ?string $maxHeight = '200px';

    protected int|string|array $columnSpan = 'full';

    protected int $titleLength = 30;

    protected function getData(): array
    {
        $articles = Article::published()
            ->popular()
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total aimé',
                    'data' => $articles->pluck('reactions_count')->toArray(),
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
