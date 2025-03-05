<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Manufactur;
use App\Models\Version;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasPermissionTo('view.widget.stats');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Category::count())
                ->description('Total products in categories')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('90 Days Notifications', Manufactur::where('notify_90_days', true)->count())
                ->description('Products with 90 days notification')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),

            Stat::make('Total Versions', Version::count())
                ->description('Total version releases')
                ->descriptionIcon('heroicon-m-code-bracket')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
        ];
    }
}
