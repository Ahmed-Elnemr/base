<?php

namespace Modules\Portfolio\Filament\Resources\Work\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Portfolio\Filament\Resources\Work\WorkResource;

class EditWork extends EditRecord
{
    protected static string $resource = WorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
