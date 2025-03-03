<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Category;

class EndOfLife extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'End of Life Data';

    protected static ?string $title = 'End of Life Data';

    protected static ?string $slug = 'end-of-life-data';

    protected static string $view = 'filament.pages.end-of-life';

    public function getData()
    {
        return Category::with(['manufactur' => function ($query) {
            $query->latest();
        }, 'version'])->get();
    }
}
