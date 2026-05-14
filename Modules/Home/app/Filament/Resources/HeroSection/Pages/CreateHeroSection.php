<?php

namespace Modules\Home\Filament\Resources\HeroSection\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Home\Filament\Resources\HeroSection\HeroSectionResource;

class CreateHeroSection extends CreateRecord
{
    protected static string $resource = HeroSectionResource::class;
}
