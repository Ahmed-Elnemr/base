<?php

namespace Modules\Portfolio\Filament\Resources\Work\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Portfolio\Filament\Resources\Work\WorkResource;

class ListWorks extends ListRecords
{
    protected static string $resource = WorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
