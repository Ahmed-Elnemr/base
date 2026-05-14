<?php

namespace Modules\CaseStudy\Filament\Resources\CaseStudy\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\CaseStudy\Filament\Resources\CaseStudy\CaseStudyResource;

class ListCaseStudies extends ListRecords
{
    protected static string $resource = CaseStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
