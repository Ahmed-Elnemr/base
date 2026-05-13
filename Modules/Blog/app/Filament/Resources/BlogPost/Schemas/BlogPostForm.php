<?php

namespace Modules\Blog\Filament\Resources\BlogPost\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Content'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->required(),
                            TextInput::make('description')
                                ->label(__('Description'))
                                ->required(),
                            RichEditor::make('content')
                                ->label(__('Content'))
                                ->required()
                                ->columnSpanFull(),
                            TagsInput::make('keywords')
                                ->label(__('Keywords'))
                                ->columnSpanFull(),
                            TextInput::make('meta_title')
                                ->label(__('Meta Title'))
                                ->columnSpanFull(),
                            TextInput::make('meta_description')
                                ->label(__('Meta Description'))
                                ->columnSpanFull(),
                        ]),
                ]),

            Section::make(__('Article URL'))
                ->columns(1)
                ->schema([
                    TextInput::make('slug')
                        ->label(__('Slug'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText(__('Used as the article URL path. Example: my-first-post')),
                ]),

            Section::make(__('Images'))
                ->columns(2)
                ->schema([
                    SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->label(__('Thumbnail'))
                        ->collection('thumbnail')
                        ->image()
                        ->required(),
                    SpatieMediaLibraryFileUpload::make('preview_image')
                        ->label(__('Preview Image'))
                        ->collection('preview_image')
                        ->image()
                        ->required(),
                ]),

            Section::make(__('Visibility'))
                ->columns(2)
                ->schema([
                    TextInput::make('sort_order')
                        ->numeric()
                        ->label(__('Order'))
                        ->default(0),
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true)
                        ->inline(false),
                ]),
        ]);
    }
}
