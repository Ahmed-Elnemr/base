<?php

namespace Modules\ServiceWork\Filament\Resources\ServiceWorkCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\ServiceWork\Filament\Resources\ServiceWorkCategoryResource;

class ListServiceWorkCategories extends ListRecords
{
    protected static string $resource = ServiceWorkCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
