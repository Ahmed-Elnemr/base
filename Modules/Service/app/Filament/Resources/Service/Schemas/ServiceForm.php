<?php

namespace Modules\Service\Filament\Resources\Service\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
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

                                Repeater::make('stats')
                                    ->label(__('Statistics'))
                                    ->schema([
                                        TextInput::make('label')->label(__('Label'))->required(),
                                        TextInput::make('value')->label(__('Value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->grid(3)
                                    ->columnSpanFull(),

                                Repeater::make('features')
                                    ->label(__('Features/Offerings'))
                                    ->schema([
                                        TextInput::make('title')->label(__('Title'))->required(),
                                        TextInput::make('description')->label(__('Description'))->required(),
                                        Select::make('icon')
                                            ->label(__('Icon'))
                                            ->options([
                                                'rocket' => 'Rocket',
                                                'pen' => 'Pen/Design',
                                                'lightbulb' => 'Lightbulb/Strategy',
                                            ])
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->columnSpanFull(),

                                Repeater::make('steps')
                                    ->label(__('Service Steps'))
                                    ->schema([
                                        TextInput::make('title')->label(__('Title'))->required(),
                                        TextInput::make('description')->label(__('Description'))->required(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                Repeater::make('faqs')
                                    ->label(__('Service FAQs'))
                                    ->schema([
                                        TextInput::make('question')->label(__('Question'))->required(),
                                        TextInput::make('answer')->label(__('Answer'))->required(),
                                    ])
                                    ->columns(1)
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
                        SpatieMediaLibraryFileUpload::make('steps_image')
                            ->label(__('Steps Section Image'))
                            ->collection('steps_image')
                            ->disk('public')
                            ->image(),
                    ]),

                Section::make(__('Related Portfolio'))
                    ->schema([
                        Select::make('relatedWorks')
                            ->label(__('Related Works'))
                            ->relationship('relatedWorks', 'title')
                            ->multiple()
                            ->preload(),
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
