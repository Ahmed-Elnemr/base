<?php

namespace Modules\About\Filament\Resources\AboutPage\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\About\Filament\Resources\AboutPage\AboutPageResource;

class ListAboutPages extends ListRecords
{
    protected static string $resource = AboutPageResource::class;

    public function mount(): void
    {
        $record = AboutPageResource::getModel()::first();
        if ($record) {
            $this->redirect(AboutPageResource::getUrl('edit', ['record' => $record]));

            return;
        }
        $this->redirect(AboutPageResource::getUrl('create'));
    }
}
