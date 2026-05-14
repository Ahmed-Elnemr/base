<?php

namespace Modules\CaseStudy\Filament\Resources\CaseStudy\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\CaseStudy\Filament\Resources\CaseStudy\CaseStudyResource;

class CreateCaseStudy extends CreateRecord
{
    protected static string $resource = CaseStudyResource::class;
}
