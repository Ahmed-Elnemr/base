<?php

namespace Modules\Catalog\Filament\Resources\Service\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Catalog\app\Models\Category;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Service details'))
                ->columns(1)
                ->schema([
                    Select::make('catalog_category_id')
                        ->label(__('Category'))
                        ->options(
                            Category::query()
                                ->active()
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->required(),
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->required(),
                            RichEditor::make('content')
                                ->label(__('Content'))
                                ->columnSpanFull(),
                        ]),
                    TextInput::make('price')
                        ->label(__('Price'))
                        ->numeric()
                        ->prefix('SAR'),
                    TextInput::make('phone')
                        ->label(__('Phone'))
                        ->tel(),
                    Repeater::make('features')
                        ->schema([
                            TextInput::make('value')
                                ->label(__('Feature'))
                                ->required(),
                        ])
                        ->label(__('Features'))
                        ->defaultItems(1)
                        ->columnSpanFull(),
                    SpatieMediaLibraryFileUpload::make('service_gallery')
                        ->label(__('Gallery'))
                        ->collection('service_gallery')
                        ->image()
                        ->multiple()
                        ->columnSpanFull(),
                ]),
            Section::make(__('Status'))
                ->columns(2)
                ->schema([
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true),
                ]),
        ]);
    }
}








