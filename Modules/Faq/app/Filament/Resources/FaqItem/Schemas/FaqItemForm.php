<?php

namespace Modules\Faq\Filament\Resources\FaqItem\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('Question & Answer'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('question')
                                ->label(__('Question'))
                                ->required(),
                            RichEditor::make('answer')
                                ->label(__('Answer'))
                                ->required()
                                ->columnSpanFull(),
                        ]),
                ]),
            Section::make(__('Metadata'))
                ->columns(2)
                ->schema([
                    TextInput::make('sort_order')
                        ->numeric()
                        ->label(__('Order'))
                        ->default(0),
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true),
                ]),
        ]);
    }
}








