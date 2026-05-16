<?php

namespace Modules\Home\Filament\Resources\CTASection\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Home\Filament\Resources\CTASection\CTASectionResource;

class ListCTASections extends ListRecords
{
    protected static string $resource = CTASectionResource::class;

    public function mount(): void
    {
        $record = CTASection::first();
        if ($record) {
            $this->redirect(CTASectionResource::getUrl('edit', ['record' => $record]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
