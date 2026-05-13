<?php

namespace Modules\Support\Filament\Resources\SupportMessage\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Support\Filament\Resources\SupportMessage\SupportMessageResource;

class ListSupportMessages extends ListRecords
{
    protected static string $resource = SupportMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
