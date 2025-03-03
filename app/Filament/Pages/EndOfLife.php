<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Category;
use Filament\Actions\Action;
use Illuminate\Support\Collection;

class EndOfLife extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'End of Life Data';
    protected static ?string $title = 'End of Life Data';
    protected static ?string $slug = 'end-of-life-data';
    protected static string $view = 'filament.pages.end-of-life';

    public $sortField = 'first_installation_date';
    public $sortDirection = 'asc';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export to Excel')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn() => route('export.excel', [
                    'sort_field' => $this->sortField,
                    'sort_direction' => $this->sortDirection
                ]))
                ->openUrlInNewTab(),
        ];
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getData(): Collection
    {
        $data = Category::with(['manufactur' => function ($query) {
            $query->latest();
        }, 'version'])->get();

        return $data->sort(function ($a, $b) {
            $aValue = $this->getValueForSort($a);
            $bValue = $this->getValueForSort($b);

            if ($this->sortDirection === 'asc') {
                return $aValue <=> $bValue;
            }
            return $bValue <=> $aValue;
        });
    }

    private function getValueForSort($category)
    {
        return match ($this->sortField) {
            'first_installation_date' => $category->manufactur->first()?->first_installation_date ?? null,
            'last_installation_date' => $category->manufactur->first()?->last_installation_date ?? null,
            'release_date' => $category->version?->release_date ?? null,
            'expiry_date' => $category->version?->expiry_date ?? null,
            default => null
        };
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->getData(),
        ];
    }
}
