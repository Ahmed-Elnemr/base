<?php

namespace Modules\Faq\Filament\Resources\FaqItem;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Faq\app\Models\FaqItem;
use Modules\Faq\Filament\Resources\FaqItem\Pages\CreateFaqItem;
use Modules\Faq\Filament\Resources\FaqItem\Pages\EditFaqItem;
use Modules\Faq\Filament\Resources\FaqItem\Pages\ListFaqItems;
use Modules\Faq\Filament\Resources\FaqItem\Schemas\FaqItemForm;
use Modules\Faq\Filament\Resources\FaqItem\Tables\FaqItemsTable;

class FaqItemResource extends Resource
{
    protected static ?string $model = FaqItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('FAQ Item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('FAQ Items');
    }

    public static function getNavigationLabel(): string
    {
        return __('FAQ Items');
    }

    public static function form(Schema $schema): Schema
    {
        return FaqItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaqItems::route('/'),
            'create' => CreateFaqItem::route('/create'),
            'edit' => EditFaqItem::route('/{record}/edit'),
        ];
    }
}








