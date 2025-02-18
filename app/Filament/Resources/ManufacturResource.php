<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufacturResource\Pages;
use App\Filament\Resources\ManufacturResource\RelationManagers;
use App\Models\Manufactur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManufacturResource extends Resource
{
    protected static ?string $model = Manufactur::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product-name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('license-duration')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('license-number')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('first-installation-date')
                    ->required(),
                Forms\Components\DatePicker::make('last-installation-date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product-name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license-duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license-number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first-installation-date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last-installation-date')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManufacturs::route('/'),
            'create' => Pages\CreateManufactur::route('/create'),
            'edit' => Pages\EditManufactur::route('/{record}/edit'),
        ];
    }
}
