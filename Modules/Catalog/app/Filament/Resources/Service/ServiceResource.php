<?php

namespace Modules\Catalog\Filament\Resources\Service;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Modules\Catalog\app\Models\Service;
use Modules\Catalog\Filament\Resources\Service\Pages\CreateServicePage;
use Modules\Catalog\Filament\Resources\Service\Pages\EditServicePage;
use Modules\Catalog\Filament\Resources\Service\Pages\ListServicesPage;
use Modules\Catalog\Filament\Resources\Service\Schemas\ServiceForm;
use Modules\Catalog\Filament\Resources\Service\Tables\ServiceTable;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('Service');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Services');
    }

    public static function getNavigationLabel(): string
    {
        return __('Services');
    }

    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServicesPage::route('/'),
            'create' => CreateServicePage::route('/create'),
            'edit' => EditServicePage::route('/{record}/edit'),
        ];
    }
}

