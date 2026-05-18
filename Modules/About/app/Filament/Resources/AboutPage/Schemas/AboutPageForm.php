<?php

namespace Modules\About\Filament\Resources\AboutPage\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make(__('Page content'))
                    ->columnSpanFull()
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
                            ->disk('public')
                            ->image()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
