<?php

namespace Modules\ServiceWork\Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Modules\ServiceWork\app\Models\ServiceWorkItem;
use Modules\ServiceWork\Filament\Resources\ServiceWorkItemResource\Pages;

class ServiceWorkItemResource extends Resource
{
    protected static ?string $model = ServiceWorkItem::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Photo;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Service Works');
    }

    public static function getNavigationLabel(): string
    {
        return __('Works');
    }

    public static function getModelLabel(): string
    {
        return __('Work');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Works');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Select::make('service_work_category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('work_image')
                    ->label(__('Image'))
                    ->collection('work_image')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->columnSpanFull()
                    ->required(),
                TranslatableTabs::make()
                    ->locales(['ar', 'en'])
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required(),
                        TextInput::make('subtitle')
                            ->label(__('Subtitle')),
                        RichEditor::make('content')
                            ->label(__('Content'))
                            ->columnSpanFull(),
                    ]),
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
                SpatieMediaLibraryImageColumn::make('work_image')
                    ->label(__('Image'))
                    ->collection('work_image'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label(__('Order'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label(__('Category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Status'))
                    ->placeholder(__('All'))
                    ->trueLabel(__('Active'))
                    ->falseLabel(__('Inactive')),
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
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceWorkItems::route('/'),
            'create' => Pages\CreateServiceWorkItem::route('/create'),
            'edit' => Pages\EditServiceWorkItem::route('/{record}/edit'),
        ];
    }
}
