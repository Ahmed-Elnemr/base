<?php

namespace Modules\Setting\Filament\Resources\Settings;

use App\SettingTypeEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Setting\app\Models\Setting;
use Modules\Setting\Filament\Resources\Settings\Pages\CreateSetting;
use Modules\Setting\Filament\Resources\Settings\Pages\EditSetting;
use Modules\Setting\Filament\Resources\Settings\Pages\ListSettings;
use Modules\Setting\Filament\Resources\Settings\Schemas\SettingForm;
use Modules\Setting\Filament\Resources\Settings\Tables\SettingsTable;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 20;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    public static function getModelLabel(): string
    {
        return __('Setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Settings');
    }

    public static function form(Schema $schema): Schema
    {
        return SettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettings::route('/'),
            // 'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
