<?php

namespace Modules\Service\Filament\Resources\Service\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Service\Filament\Resources\Service\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;
}
