<?php

namespace Modules\ServiceWork\Filament\Resources\ServiceWorkCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\ServiceWork\Filament\Resources\ServiceWorkCategoryResource;

class EditServiceWorkCategory extends EditRecord
{
    protected static string $resource = ServiceWorkCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
