<?php

namespace Modules\Catalog\Filament\Resources\Category\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Category details'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->columnSpanFull(),
                        ]),
                    SpatieMediaLibraryFileUpload::make('category_image')
                        ->label(__('Image'))
                        ->collection('category_image')
                        ->image()
                        ->columnSpanFull()
                        ->required(),
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








