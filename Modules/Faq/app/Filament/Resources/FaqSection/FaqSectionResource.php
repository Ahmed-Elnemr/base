<?php

namespace Modules\Faq\Filament\Resources\FaqSection;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Faq\app\Models\FaqSection;
use Modules\Faq\Filament\Resources\FaqSection\Pages\CreateFaqSection;
use Modules\Faq\Filament\Resources\FaqSection\Pages\EditFaqSection;
use Modules\Faq\Filament\Resources\FaqSection\Pages\ListFaqSections;
use Modules\Faq\Filament\Resources\FaqSection\Schemas\FaqSectionForm;
use Modules\Faq\Filament\Resources\FaqSection\Tables\FaqSectionsTable;

class FaqSectionResource extends Resource
{
    protected static ?string $model = FaqSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('FAQ');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaqSections::route('/'),
            'create' => CreateFaqSection::route('/create'),
            'edit' => EditFaqSection::route('/{record}/edit'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return FaqSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqSectionsTable::configure($table);
    }
}

