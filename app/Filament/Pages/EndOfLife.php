<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Category;
use Filament\Actions\Action;
use App\Http\Controllers\ExportController;

class EndOfLife extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'End of Life Data';
    protected static ?string $title = 'End of Life Data';
    protected static ?string $slug = 'end-of-life-data';
    protected static string $view = 'filament.pages.end-of-life';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export to Excel')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->url(route('export.excel'))
                ->openUrlInNewTab(),
        ];
    }

    public function getData()
    {
        return Category::with(['manufactur' => function ($query) {
            $query->latest();
        }, 'version'])->get();
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->getData(),
        ];
    }
}
