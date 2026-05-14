<?php

namespace Modules\Home\Filament\Resources\HomeStat\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Home\Filament\Resources\HomeStat\HomeStatResource;

class EditHomeStat extends EditRecord
{
    protected static string $resource = HomeStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
