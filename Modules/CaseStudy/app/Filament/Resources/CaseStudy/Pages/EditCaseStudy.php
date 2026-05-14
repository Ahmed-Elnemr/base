<?php

namespace Modules\CaseStudy\Filament\Resources\CaseStudy\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\CaseStudy\Filament\Resources\CaseStudy\CaseStudyResource;

class EditCaseStudy extends EditRecord
{
    protected static string $resource = CaseStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
