<?php

namespace Modules\About\Filament\Resources\AboutPage\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\About\Filament\Resources\AboutPage\AboutPageResource;

class CreateAboutPage extends CreateRecord
{
    protected static string $resource = AboutPageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
