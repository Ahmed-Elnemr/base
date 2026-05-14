<?php

namespace Modules\Portfolio\Filament\Resources\Work\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make(__('Work Details'))
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TranslatableTabs::make()
                            ->locales(['ar', 'en'])
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required(),
                                TextInput::make('subtitle')
                                    ->label(__('Subtitle')),
                            ]),
                        Select::make('type')
                            ->label(__('Type'))
                            ->options([
                                'image' => __('Image'),
                                'video' => __('Video'),
                            ])
                            ->required()
                            ->default('image')
                            ->live(),
                        TextInput::make('sort_order')
                            ->label(__('Sort Order'))
                            ->numeric()
                            ->default(0),
                        SpatieMediaLibraryFileUpload::make('work_thumbnail')
                            ->label(fn ($get) => $get('type') === 'video' ? __('Video Thumbnail') : __('Image'))
                            ->collection('work_thumbnail')
                            ->image()
                            ->required()
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('work_file')
                            ->label(__('Video File'))
                            ->collection('work_file')
                            ->visible(fn ($get) => $get('type') === 'video')
                            ->required(fn ($get) => $get('type') === 'video')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true),
                    ]),
            ]);
    }
}
