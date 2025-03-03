<?php

namespace App\Filament\Widgets;

use App\Models\Manufactur;
use Filament\Widgets\ChartWidget;

class ProductByManufactureChart extends ChartWidget
{
    protected static ?string $heading = 'Products by Manufacture';

    protected static ?int $sort = 2;

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
        $manufactures = Manufactur::all();

        return [
            'datasets' => [
                [
                    'label' => 'Products by Manufacture',
                    'data' => $manufactures->map(fn($manufacture) => 1)->toArray(),
                    'backgroundColor' => '#3b82f6', // Blue color
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $manufactures->pluck('category_id')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
