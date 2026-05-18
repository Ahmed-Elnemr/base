<?php

namespace Modules\CaseStudy\Filament\Resources\CaseStudy\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CaseStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make(__('Case Study Content'))
                    ->columnSpanFull()
                    ->columns(1)
                    ->schema([
                        TranslatableTabs::make()
                            ->locales(['ar', 'en'])
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->lazy()
                                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
                                RichEditor::make('description')
                                    ->label(__('Description'))
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        SpatieMediaLibraryFileUpload::make('case_study_image')
                            ->label(__('Main Image'))
                            ->collection('case_study_image')
                            ->disk('public')
                            ->image()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true),
                    ]),
            ]);
    }
}
