<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Version;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use App\Filament\Resources\VersionResource\Pages;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function getNavigationGroup(): ?string
    {
        if (auth()->user()->hasRole('user')) {
            return 'Actions';
        }

        return null;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true; // Allow both roles to see the resource
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Product Category')
                    ->relationship('category', 'product_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('version_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('version_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('release_date')
                    ->required(),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label('Expiry Date')
                    ->required(),
                Forms\Components\Textarea::make('version_description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\CheckboxList::make('notification_periods')
                    ->label('Notification Periods')
                    ->options([
                        'notify_90_days' => '90 days before expiry',
                        'notify_30_days' => '30 days before expiry',
                        'notify_7_days' => '7 days before expiry',
                    ])
                    ->columns(3)
                    ->maxItems(2)
                    ->helperText('Select up to 2 notification periods')
                    ->reactive()
                    ->afterStateHydrated(function ($state, $record, callable $set) {
                        if ($record) {
                            $selected = [];
                            if ($record->notify_90_days) $selected[] = 'notify_90_days';
                            if ($record->notify_30_days) $selected[] = 'notify_30_days';
                            if ($record->notify_7_days) $selected[] = 'notify_7_days';
                            $set('notification_periods', $selected);
                        }
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (count($state) > 2) {
                            array_pop($state);
                            $set('notification_periods', $state);
                        }

                        // Reset all notification flags first
                        $set('notify_90_days', false);
                        $set('notify_30_days', false);
                        $set('notify_7_days', false);
                        $set('is_notified_90', false);
                        $set('is_notified_30', false);
                        $set('is_notified_7', false);

                        // Set new notification flags
                        foreach ($state as $notification) {
                            $set($notification, true);
                        }
                    })
                    ->dehydrated(false),

                // Hidden fields for notification flags
                Forms\Components\Hidden::make('notify_90_days'),
                Forms\Components\Hidden::make('notify_30_days'),
                Forms\Components\Hidden::make('notify_7_days'),
                Forms\Components\Hidden::make('is_notified_90'),
                Forms\Components\Hidden::make('is_notified_30'),
                Forms\Components\Hidden::make('is_notified_7'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('version_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.product_name')
                    ->label('Product Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('version_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVersions::route('/'),
        ];
    }
}
