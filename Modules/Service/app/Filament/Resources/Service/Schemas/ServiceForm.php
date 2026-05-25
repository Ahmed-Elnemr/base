<?php

namespace Modules\Service\Filament\Resources\Service\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make(__('Basic Information'))
                    ->columns(2)
                    ->schema([
                        Select::make('service_category_id')
                            ->label(__('Category'))
                            ->relationship('category', 'name')
                            ->required(),
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->required()
                            ->unique('services', 'slug', ignoreRecord: true),
                        TranslatableTabs::make()
                            ->locales(['ar', 'en'])
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                TextInput::make('short_description')
                                    ->label(__('Short Description'))
                                    ->required(),
                                RichEditor::make('description')
                                    ->label(__('Description'))
                                    ->required()
                                    ->columnSpanFull(),

                            ]),
                    ]),

                Section::make(__('Media'))
                    ->columns(2)
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('service_image')
                            ->label(__('Service Image'))
                            ->collection('service_image')
                            ->disk('public')
                            ->image()
                            ->required(),
                    ]),

                Section::make(__('Related Portfolio'))
                    ->schema([
                        Repeater::make('related_works')
                            ->label(__('Related Works'))
                            ->schema([
                                FileUpload::make('image')
                                    ->label(__('Image'))
                                    ->image()
                                    ->directory('service_related_works')
                                    ->required(),
                                TextInput::make('title_ar')
                                    ->label(__('Title (Arabic)')),
                                TextInput::make('title_en')
                                    ->label(__('Title (English)')),
                            ])
                            ->columns(1)
                            ->defaultItems(0),
                    ]),

                Section::make(__('Settings'))
                    ->schema([
                        TextInput::make('sort_order')
                            ->label(__('Sort Order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true),
                    ]),
            ]);
    }
}
