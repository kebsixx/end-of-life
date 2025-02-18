<?php

namespace App\Filament\Resources\ManufacturResource\Pages;

use App\Filament\Resources\ManufacturResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManufacturs extends ListRecords
{
    protected static string $resource = ManufacturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
