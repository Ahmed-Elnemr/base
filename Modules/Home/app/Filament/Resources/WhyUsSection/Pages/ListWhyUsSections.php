<?php

namespace Modules\Home\Filament\Resources\WhyUsSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\WhyUsSection\WhyUsSectionResource;

class ListWhyUsSections extends ListRecords
{
    protected static string $resource = WhyUsSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
