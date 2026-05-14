<?php

namespace Modules\Service\Filament\Resources\ServiceCategory\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Service\Filament\Resources\ServiceCategory\ServiceCategoryResource;

class ListServiceCategories extends ListRecords
{
    protected static string $resource = ServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
