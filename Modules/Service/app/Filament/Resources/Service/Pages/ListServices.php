<?php

namespace Modules\Service\Filament\Resources\Service\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Service\Filament\Resources\Service\ServiceResource;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
