<?php

namespace Modules\Setting\Filament\Resources\Settings\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Setting\Filament\Resources\Settings\SettingResource;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
}
