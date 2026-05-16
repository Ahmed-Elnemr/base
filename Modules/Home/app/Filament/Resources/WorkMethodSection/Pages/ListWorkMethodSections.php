<?php

namespace Modules\Home\Filament\Resources\WorkMethodSection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\WorkMethodSection\WorkMethodSectionResource;

class ListWorkMethodSections extends ListRecords
{
    protected static string $resource = WorkMethodSectionResource::class;

    public function mount(): void
    {
        $record = WorkMethodSection::first();
        if ($record) {
            $this->redirect(WorkMethodSectionResource::getUrl('edit', ['record' => $record]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
