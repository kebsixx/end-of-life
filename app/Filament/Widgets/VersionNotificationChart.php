<?php

namespace App\Filament\Widgets;

use App\Models\Version;
use App\Models\Category;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class VersionNotificationChart extends ChartWidget
{
    protected static ?string $heading = 'Version Notifications by Category (90 Days)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'height' => 400,
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'grid' => ['display' => false],
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'grid' => ['display' => false],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'padding' => 12,
                    'displayColors' => true,
                    'callbacks' => [
                        'label' => "function(context) {
                            const value = context.parsed.y;
                            if (!value) return null;
                            
                            const version = context.dataset.versions[context.dataIndex];
                            if (!version) return null;
                            
                            return [
                                'Category: ' + context.dataset.label,
                                'End of Life: ' + version.expiry_date,
                                'Total Versions: ' + value
                            ];
                        }",
                    ],
                ],
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 20,
                    ],
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $categories = Category::all();
        $months = collect();

        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }

        $datasets = [];
        $colors = [
            '#3b82f6', // Blue
            '#10b981', // Green
            '#f59e0b', // Yellow
            '#ef4444', // Red
            '#8b5cf6', // Purple
        ];

        foreach ($categories as $index => $category) {
            $monthlyData = [];
            $versionData = [];

            foreach ($months as $month) {
                $versions = Version::query()
                    ->where('category_id', $category->id)
                    ->where('notify_90_days', true)
                    ->whereMonth('release_date', Carbon::parse($month)->month)
                    ->whereYear('release_date', Carbon::parse($month)->year)
                    ->get();

                $count = $versions->count();
                $monthlyData[] = $count;

                // Get all version details for this month
                $versionData[] = $count > 0 ? [
                    'expiry_date' => $versions->first()->expiry_date->format('M Y'),
                    'total' => $count,
                ] : null;
            }

            $datasets[] = [
                'label' => $category->product_name,
                'data' => $monthlyData,
                'backgroundColor' => $colors[$index % count($colors)],
                'borderColor' => $colors[$index % count($colors)],
                'borderWidth' => 1,
                'versions' => $versionData,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $months->map(fn($month) => Carbon::parse($month)->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
