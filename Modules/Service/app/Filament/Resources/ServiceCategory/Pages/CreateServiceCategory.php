<?php

namespace Modules\Service\Filament\Resources\ServiceCategory\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Service\Filament\Resources\ServiceCategory\ServiceCategoryResource;

class CreateServiceCategory extends CreateRecord
{
    protected static string $resource = ServiceCategoryResource::class;
}
