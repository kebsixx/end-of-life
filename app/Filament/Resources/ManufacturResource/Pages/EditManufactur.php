<?php

namespace App\Filament\Resources\ManufacturResource\Pages;

use App\Filament\Resources\ManufacturResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManufactur extends EditRecord
{
    protected static string $resource = ManufacturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
