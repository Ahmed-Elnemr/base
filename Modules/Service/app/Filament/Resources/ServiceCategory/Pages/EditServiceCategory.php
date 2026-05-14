<?php

namespace Modules\Service\Filament\Resources\ServiceCategory\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Service\Filament\Resources\ServiceCategory\ServiceCategoryResource;

class EditServiceCategory extends EditRecord
{
    protected static string $resource = ServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
