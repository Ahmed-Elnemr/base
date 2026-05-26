<?php

namespace Modules\Setting\Filament\Resources\GeneralSetting;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
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

    public static function getModelLabel(): string
    {
        return __('General Setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('General Settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    protected static ?int $navigationSort = 100;

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

                Section::make(__('Occasion'))
                    ->schema([
                        Toggle::make('occasion_is_active')
                            ->label(__('Active'))
                            ->default(false),
                        TranslatableTabs::make('occasion_tabs')
                            ->locales(['ar', 'en'])
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('occasion_title')
                                    ->label(__('Occasion Title')),
                                Textarea::make('occasion_content')
                                    ->label(__('Occasion Content'))
                                    ->rows(3),
                            ]),
                        SpatieMediaLibraryFileUpload::make('occasion_image')
                            ->label(__('Occasion Image'))
                            ->collection('occasion_image')
                            ->disk('public')
                            ->image(),
                    ]),
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
