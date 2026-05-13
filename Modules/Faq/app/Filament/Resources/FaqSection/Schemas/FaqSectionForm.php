<?php

namespace Modules\Faq\Filament\Resources\FaqSection\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('FAQ intro'))
                ->columns(1)
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['ar', 'en'])
                        ->columnSpanFull()
                        ->schema([
                            RichEditor::make('title')
                                ->label(__('Title'))
                                ->nullable(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->nullable()
                                ->columnSpanFull(),
                        ]),
                ]),
        ]);
    }
}

