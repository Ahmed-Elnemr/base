<?php

namespace Modules\Service\Filament\Resources\Service;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Service\app\Models\Service;
use Modules\Service\Filament\Resources\Service\Pages\CreateService;
use Modules\Service\Filament\Resources\Service\Pages\EditService;
use Modules\Service\Filament\Resources\Service\Pages\ListServices;
use Modules\Service\Filament\Resources\Service\Schemas\ServiceForm;
use Modules\Service\Filament\Resources\Service\Tables\ServicesTable;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Services Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Services');
    }

    public static function getModelLabel(): string
    {
        return __('Service');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Services');
    }

    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
