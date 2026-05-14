<?php

namespace Modules\Project\Filament\Resources\ProjectRequest\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Project\Filament\Resources\ProjectRequest\ProjectRequestResource;

class ListProjectRequests extends ListRecords
{
    protected static string $resource = ProjectRequestResource::class;
}
