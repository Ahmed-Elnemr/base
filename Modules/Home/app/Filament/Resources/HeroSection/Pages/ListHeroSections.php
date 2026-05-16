<?php

namespace Modules\Home\Filament\Resources\HeroSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\HeroSection\HeroSectionResource;

class ListHeroSections extends ListRecords
{
    protected static string $resource = HeroSectionResource::class;

    public function mount(): void
    {
        $record = HeroSection::first();
        if ($record) {
            $this->redirect(HeroSectionResource::getUrl('edit', ['record' => $record]));
        } else {
            // If no record, maybe create one or show create page
            // For now, if no record, let it show the empty table or redirect to create if we want
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
