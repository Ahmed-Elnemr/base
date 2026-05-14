<?php

namespace Modules\Home\Filament\Resources\HomeStat\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Home\Filament\Resources\HomeStat\HomeStatResource;

class CreateHomeStat extends CreateRecord
{
    protected static string $resource = HomeStatResource::class;
}
