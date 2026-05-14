<?php

namespace Modules\Home\Filament\Resources\WorkMethodSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\WorkMethodSection\WorkMethodSectionResource;

class ListWorkMethodSections extends ListRecords
{
    protected static string $resource = WorkMethodSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
