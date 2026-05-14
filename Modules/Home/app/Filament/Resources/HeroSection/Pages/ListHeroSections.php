<?php

namespace Modules\Home\Filament\Resources\HeroSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\HeroSection\HeroSectionResource;

class ListHeroSections extends ListRecords
{
    protected static string $resource = HeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
