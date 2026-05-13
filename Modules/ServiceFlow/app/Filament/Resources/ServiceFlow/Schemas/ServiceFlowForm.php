<?php

namespace Modules\ServiceFlow\Filament\Resources\ServiceFlow\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceFlowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Intro'))
                ->columns(1)
                ->schema([
                    TextInput::make('step_number')
                        ->label(__('Step number'))
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('sort_order')
                        ->label(__('Sort order'))
                        ->numeric()
                        ->default(fn (?int $value) => $value ?? 0)
                        ->columnSpanFull(),
                    SpatieMediaLibraryFileUpload::make('step_image')
                        ->label(__('Step image'))
                        ->collection('step_image')
                        ->image()
                        ->required()
                        ->columnSpanFull(),
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

