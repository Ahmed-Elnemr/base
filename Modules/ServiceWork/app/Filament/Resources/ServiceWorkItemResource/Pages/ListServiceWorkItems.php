<?php

namespace Modules\ServiceWork\Filament\Resources\ServiceWorkItemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\ServiceWork\Filament\Resources\ServiceWorkItemResource;

class ListServiceWorkItems extends ListRecords
{
    protected static string $resource = ServiceWorkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
