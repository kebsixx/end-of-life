<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufacturResource\Pages;
use App\Models\Manufactur;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManufacturResource extends Resource
{
    protected static ?string $model = Manufactur::class;

    protected static ?string $navigationIcon = 'heroicon-m-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label('Product Name')
                    ->options(Category::query()->pluck('name', 'name'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('license_duration')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('license_number')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('first_installation_date')
                    ->required(),
                Forms\Components\DatePicker::make('last_installation_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_installation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_installation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
