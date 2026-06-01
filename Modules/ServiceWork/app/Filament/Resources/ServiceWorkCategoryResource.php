<?php

namespace Modules\ServiceWork\Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\ServiceWork\app\Models\ServiceWorkCategory;
use Modules\ServiceWork\Filament\Resources\ServiceWorkCategoryResource\Pages;

class ServiceWorkCategoryResource extends Resource
{
    protected static ?string $model = ServiceWorkCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Folder;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Service Works');
    }

    public static function getNavigationLabel(): string
    {
        return __('Categories');
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Categories');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                TranslatableTabs::make()
                    ->locales(['ar', 'en'])
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set, $livewire) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                if ($livewire->activeLocale === 'en') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                    ]),
                TextInput::make('slug')
                    ->label(__('Slug'))
                    ->required()
                    ->unique(ServiceWorkCategory::class, 'slug', ignoreRecord: true),
                TextInput::make('sort_order')
                    ->label(__('Sort Order'))
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label(__('Active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label(__('Sort Order'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active'))
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
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceWorkCategories::route('/'),
            'create' => Pages\CreateServiceWorkCategory::route('/create'),
            'edit' => Pages\EditServiceWorkCategory::route('/{record}/edit'),
        ];
    }
}
