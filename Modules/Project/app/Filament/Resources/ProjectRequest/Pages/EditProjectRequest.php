<?php

namespace Modules\Project\Filament\Resources\ProjectRequest\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Project\Filament\Resources\ProjectRequest\ProjectRequestResource;

class EditProjectRequest extends EditRecord
{
    protected static string $resource = ProjectRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
