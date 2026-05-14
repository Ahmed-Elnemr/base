<?php

namespace Modules\About\Filament\Resources\AboutPage\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\About\Filament\Resources\AboutPage\AboutPageResource;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
