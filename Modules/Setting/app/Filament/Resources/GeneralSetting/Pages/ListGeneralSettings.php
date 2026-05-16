<?php

namespace Modules\Setting\Filament\Resources\GeneralSetting\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Setting\Filament\Resources\GeneralSetting\GeneralSettingResource;

class ListGeneralSettings extends ListRecords
{
    protected static string $resource = GeneralSettingResource::class;

    public function mount(): void
    {
        $record = GeneralSettingResource::getModel()::first();
        if ($record) {
            $this->redirect(GeneralSettingResource::getUrl('edit', ['record' => $record]));
            return;
        }
        
        // If no record exists, we create one (since it's a singleton)
        $record = GeneralSettingResource::getModel()::create([
            'email' => 'admin@example.com',
            'phone' => '123456789',
            'website' => 'example.com',
            'address' => ['en' => 'Default Address', 'ar' => 'عنوان افتراضي'],
        ]);
        
        $this->redirect(GeneralSettingResource::getUrl('edit', ['record' => $record]));
    }
}
