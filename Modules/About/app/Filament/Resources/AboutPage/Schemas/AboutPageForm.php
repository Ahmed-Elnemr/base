<?php

namespace Modules\About\Filament\Resources\AboutPage\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                            RichEditor::make('intro')
                                ->label(__('Intro copy'))
                                ->required()
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'bulletList',
                                    'orderedList',
                                ]),
                            RichEditor::make('content')
                                ->label(__('Body'))
                                ->required()
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

