<?php

namespace Modules\Portfolio\Filament\Resources\Work;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Portfolio\app\Models\Work;
use Modules\Portfolio\Filament\Resources\Work\Pages\CreateWork;
use Modules\Portfolio\Filament\Resources\Work\Pages\EditWork;
use Modules\Portfolio\Filament\Resources\Work\Pages\ListWorks;
use Modules\Portfolio\Filament\Resources\Work\Schemas\WorkForm;
use Modules\Portfolio\Filament\Resources\Work\Tables\WorksTable;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Content Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Portfolio');
    }

    public static function getModelLabel(): string
    {
        return __('Work');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Portfolio');
    }

    public static function form(Schema $schema): Schema
    {
        return WorkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorks::route('/'),
            'create' => CreateWork::route('/create'),
            'edit' => EditWork::route('/{record}/edit'),
        ];
    }
}
