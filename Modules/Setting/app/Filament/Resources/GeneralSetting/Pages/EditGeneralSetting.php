<?php

namespace Modules\Setting\Filament\Resources\GeneralSetting\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\Setting\Filament\Resources\GeneralSetting\GeneralSettingResource;

class EditGeneralSetting extends EditRecord
{
    protected static string $resource = GeneralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
