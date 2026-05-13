<?php

namespace Modules\Support\Filament\Resources\SupportPage;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Support\app\Models\SupportPage;
use Modules\Support\Filament\Resources\SupportPage\Pages\CreateSupportPage;
use Modules\Support\Filament\Resources\SupportPage\Pages\EditSupportPage;
use Modules\Support\Filament\Resources\SupportPage\Pages\ListSupportPages;
use Modules\Support\Filament\Resources\SupportPage\RelationManagers\MessagesRelationManager;
use Modules\Support\Filament\Resources\SupportPage\Schemas\SupportPageForm;
use Modules\Support\Filament\Resources\SupportPage\Tables\SupportPagesTable;

class SupportPageResource extends Resource
{
    protected static ?string $model = SupportPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('Support center');
    }

    public static function form(Schema $schema): Schema
    {
        return SupportPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupportPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupportPages::route('/'),
            'create' => CreateSupportPage::route('/create'),
            'edit' => EditSupportPage::route('/{record}/edit'),
        ];
    }
}

