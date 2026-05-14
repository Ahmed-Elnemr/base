<?php

namespace Modules\Home\Filament\Resources\CTASection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\CTASection\CTASectionResource;

class ListCTASections extends ListRecords
{
    protected static string $resource = CTASectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
