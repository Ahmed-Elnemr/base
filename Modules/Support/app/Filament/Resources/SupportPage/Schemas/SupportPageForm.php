<?php

namespace Modules\Support\Filament\Resources\SupportPage\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupportPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Support content'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            RichEditor::make('title')
                                ->label(__('Title'))
                                ->required(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    SpatieMediaLibraryFileUpload::make('support_image')
                        ->label(__('Visual'))
                        ->collection('support_image')
                        ->image()
                        ->required()
                        ->columnSpanFull(),
                ]),
            Section::make(__('Visibility'))
                ->columns(1)
                ->schema([
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true),
                ]),
        ]);
    }
}

