<?php

namespace Modules\Slider\Filament\Resources\Slider\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Slider content'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            RichEditor::make('title')
                                ->label(__('Title'))
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'bulletList',
                                    'orderedList',
                                ])
                                ->required(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'underline',
                                    'bulletList',
                                    'orderedList',
                                    'link',
                                ])
                                ->columnSpanFull(),
                        ]),
                    SpatieMediaLibraryFileUpload::make('slider_cover')
                        ->label(__('Slider image'))
                        ->collection('slider_cover')
                        ->image()
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make(__('Publishing'))
                ->columns(1)
                ->schema([
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true),
                    TextInput::make('sort_order')
                        ->label(__('Sort order'))
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('published_at')
                        ->label(__('Publish at'))
                        ->seconds(false),
                ])->columns(2),
        ]);
    }
}

