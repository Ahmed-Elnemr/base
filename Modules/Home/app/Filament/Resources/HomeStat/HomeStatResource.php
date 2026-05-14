<?php

namespace Modules\Home\Filament\Resources\HomeStat;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\HomeStat;
use Modules\Home\Filament\Resources\HomeStat\Pages\CreateHomeStat;
use Modules\Home\Filament\Resources\HomeStat\Pages\EditHomeStat;
use Modules\Home\Filament\Resources\HomeStat\Pages\ListHomeStats;

class HomeStatResource extends Resource
{
    protected static ?string $model = HomeStat::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::ChartBar;

    public static function getModelLabel(): string
    {
        return __('Stat');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Stats');
    }

    protected static ?int $navigationSort = 11;

    public static function getNavigationGroup(): ?string
    {
        return __('Home Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Stats');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TranslatableTabs::make()
                    ->locales(['en', 'ar'])
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required(),
                    ])->columnSpanFull(),
                TextInput::make('value')
                    ->label(__('Value'))
                    ->placeholder('e.g. 400+')
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
                TextInput::make('sort_order')
                    ->label(__('Sort Order'))
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                TextColumn::make('value')
                    ->label(__('Value')),
                IconColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label(__('Sort Order'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomeStats::route('/'),
            'create' => CreateHomeStat::route('/create'),
            'edit' => EditHomeStat::route('/{record}/edit'),
        ];
    }
}
