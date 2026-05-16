<?php

namespace Modules\Home\Filament\Resources\WhyUsSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\WhyUsSection\WhyUsSectionResource;

class ListWhyUsSections extends ListRecords
{
    protected static string $resource = WhyUsSectionResource::class;

    public function mount(): void
    {
        $record = WhyUsSection::first();
        if ($record) {
            $this->redirect(WhyUsSectionResource::getUrl('edit', ['record' => $record]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
