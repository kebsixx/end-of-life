<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufacturResource\Pages;
use App\Models\Manufactur;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
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
                    ->options(Category::query()->pluck('product_name', 'product_name'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('license_duration')
                    ->label('License Duration')
                    ->placeholder('1 year')
                    ->helperText('Example: 1 year, 6 months, etc.')
                    ->required(),
                Forms\Components\TextInput::make('license_number')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('first_installation_date')
                    ->label('First Installation Date')
                    ->required(),
                Forms\Components\DatePicker::make('last_installation_date')
                    ->label('Last Installation Date')
                    ->required(),
                Forms\Components\TextInput::make('notification_period')
                    ->label('Notification Before Expiry')
                    ->placeholder('1 week')
                    ->helperText('Example: 1 day, 3 days, 1 week, etc.')
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
                    ->label('Duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_installation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_installation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notification_period')
                    ->label('Notify Before')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_notified')
                    ->label('Notification Sent')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
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
