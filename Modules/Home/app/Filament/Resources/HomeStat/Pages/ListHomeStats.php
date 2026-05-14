<?php

namespace Modules\Home\Filament\Resources\HomeStat\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\HomeStat\HomeStatResource;

class ListHomeStats extends ListRecords
{
    protected static string $resource = HomeStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
