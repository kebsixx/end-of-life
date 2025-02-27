<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Products Deployed by Category';

    protected static ?int $sort = 1;

    // Make chart horizontal
    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $categories = Category::all();
        $colors = [
            '#3b82f6', // Blue
            '#60a5fa', // Light blue
            '#2563eb', // Dark blue
            '#1d4ed8', // Deeper blue
            '#1e40af', // Navy blue
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Products Deployed',
                    'data' => $categories->map(fn($category) => 1)->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $categories->count()),
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $categories->pluck('product_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
