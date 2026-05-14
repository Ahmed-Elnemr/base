<?php

namespace Modules\About\Filament\Resources\AboutPage\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Page content'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('sub_title')
                                ->label(__('Sub Title'))
                                ->placeholder(__('About Us'))
                                ->required(),
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->placeholder(__('Agency Name'))
                                ->required(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->required()
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'bulletList',
                                    'orderedList',
                                ])
                                ->columnSpanFull(),
                        ]),
                    SpatieMediaLibraryFileUpload::make('about_image')
                        ->label(__('Primary image'))
                        ->collection('about_image')
                        ->image()
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make(__('Visibility'))
                ->columns(1)
                ->schema([
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true)
                        ->inline(false),
                ]),
        ]);
    }
}

