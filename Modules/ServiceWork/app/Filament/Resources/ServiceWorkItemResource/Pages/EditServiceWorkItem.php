<?php

namespace Modules\ServiceWork\Filament\Resources\ServiceWorkItemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\ServiceWork\Filament\Resources\ServiceWorkItemResource;

class EditServiceWorkItem extends EditRecord
{
    protected static string $resource = ServiceWorkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
