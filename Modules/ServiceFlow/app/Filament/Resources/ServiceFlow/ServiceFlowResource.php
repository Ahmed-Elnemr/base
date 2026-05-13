<?php

namespace Modules\ServiceFlow\Filament\Resources\ServiceFlow;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\ServiceFlow\app\Models\ServiceFlow;
use Modules\ServiceFlow\Filament\Resources\ServiceFlow\Pages\CreateServiceFlow;
use Modules\ServiceFlow\Filament\Resources\ServiceFlow\Pages\EditServiceFlow;
use Modules\ServiceFlow\Filament\Resources\ServiceFlow\Pages\ListServiceFlows;
use Modules\ServiceFlow\Filament\Resources\ServiceFlow\Schemas\ServiceFlowForm;
use Modules\ServiceFlow\Filament\Resources\ServiceFlow\Tables\ServiceFlowsTable;

class ServiceFlowResource extends Resource
{
    protected static ?string $model = ServiceFlow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('How to order');
    }

    public static function getModelLabel(): string
    {
        return __('Service flow');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Service flows');
    }

    public static function form(Schema $schema): Schema
    {
        return ServiceFlowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceFlowsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServiceFlows::route('/'),
            'create' => CreateServiceFlow::route('/create'),
            'edit' => EditServiceFlow::route('/{record}/edit'),
        ];
    }
}

