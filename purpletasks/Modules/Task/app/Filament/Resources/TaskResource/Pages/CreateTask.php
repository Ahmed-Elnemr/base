<?php

namespace Modules\Task\Filament\Resources\TaskResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Task\Filament\Resources\TaskResource;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;
}
