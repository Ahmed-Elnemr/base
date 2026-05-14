<?php

namespace Modules\Service\Filament\Resources\Service\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Service\Filament\Resources\Service\ServiceResource;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
