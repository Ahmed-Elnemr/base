<?php

namespace Modules\Setting\Filament\Resources\GeneralSetting;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Modules\Setting\app\Models\GeneralSetting;
use Modules\Setting\Filament\Resources\GeneralSetting\Pages\EditGeneralSetting;
use Modules\Setting\Filament\Resources\GeneralSetting\Pages\ListGeneralSettings;

class GeneralSettingResource extends Resource
{
    protected static ?string $model = GeneralSetting::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Cog;

    public static function getNavigationLabel(): string
    {
        return __('General Settings');
    }

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(): string
    {
        $record = GeneralSetting::first();
        if ($record) {
            return static::getUrl('edit', ['record' => $record]);
        }
        return static::getUrl('index');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                TranslatableTabs::make()
                    ->locales(['ar', 'en'])
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('address')
                            ->label(__('Address'))
                            ->required(),
                    ]),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->required(),
                SpatieMediaLibraryFileUpload::make('logo_header')
                    ->label(__('Header Logo'))
                    ->collection('logo_header')
                    ->disk('public')
                    ->image()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('logo_footer')
                    ->label(__('Footer Logo'))
                    ->collection('logo_footer')
                    ->disk('public')
                    ->image()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('logo_admin')
                    ->label(__('Admin Logo'))
                    ->collection('logo_admin')
                    ->disk('public')
                    ->image()
                    ->required(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGeneralSettings::route('/'),
            'edit' => EditGeneralSetting::route('/{record}/edit'),
        ];
    }
}
