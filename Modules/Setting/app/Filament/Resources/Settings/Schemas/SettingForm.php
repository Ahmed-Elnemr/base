<?php

namespace Modules\Setting\Filament\Resources\Settings\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\SettingTypeEnum;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

// Forms Components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\KeyValue;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('Basic Information'))
                ->schema([
                    TranslatableTabs::make()
                        ->locales(['en', 'ar'])
                        ->schema([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                        ]),
                ]),

            Section::make(__('Details'))
                ->schema([
                    TextInput::make('key')
                        ->label(__('Key'))
                        ->disabled()
                        ->required(),

                    Group::make()
                        ->schema([
                            Select::make('type')
                                ->label(__('Type'))
                                ->options(collect(SettingTypeEnum::cases())->mapWithKeys(function ($case) {
                                    return [$case->value => $case->name];
                                })->toArray())
                                ->disabled()
                                ->required(),

                            Toggle::make('is_translatable')
                                ->label(__('Translatable Value'))
                                ->disabled(),
                        ])->columns(2),
                ]),

            Section::make(__('Value'))
                ->schema([
                    static::getDynamicValueField(),
                ]),
        ]);
    }

    private static function getDynamicValueField()
    {
        return Group::make()
            ->schema(function ($get) {

                $type = $get('type');
                $isTranslatable = $get('is_translatable');

                return match ($type) {

                    // SHORT TEXT
                    SettingTypeEnum::SHORT_TEXT->value =>
                    $isTranslatable
                        ? [
                        TranslatableTabs::make()
                            ->locales(['en', 'ar'])
                            ->schema([
                                TextInput::make('value')->label('Value')->required()
                            ]),
                    ]
                        : [
                        TextInput::make('value')->label('Value')
                    ],

                    // LONG TEXT
                    SettingTypeEnum::LONG_TEXT->value =>
                    $isTranslatable
                        ? [
                        TranslatableTabs::make()
                            ->locales(['en', 'ar'])
                            ->schema([
                                Textarea::make('value')->label('Value')->rows(5)->required()
                            ]),
                    ]
                        : [
                        Textarea::make('value')->label('Value')->rows(5)
                    ],

                    // RICH TEXT
                    SettingTypeEnum::RICH_TEXT->value =>
                    $isTranslatable
                        ? [
                        TranslatableTabs::make()
                            ->locales(['en', 'ar'])
                            ->schema([
                                RichEditor::make('value')->label('Value')->required()
                            ]),
                    ]
                        : [
                        RichEditor::make('value')->label('Value')
                    ],

                    // INTEGER
                    SettingTypeEnum::INTEGER->value => [
                        TextInput::make('value')->label('Value')->numeric()
                    ],

                    // DECIMAL
                    SettingTypeEnum::DECIMAL->value => [
                        TextInput::make('value')->label('Value')->numeric()->step('0.01')
                    ],

                    // BOOLEAN
                    SettingTypeEnum::BOOLEAN->value => [
                        Toggle::make('value')->label('Value')
                    ],

                    /// MEDIA
                    /// MEDIA
                    /// MEDIA
                    SettingTypeEnum::IMAGE->value,
                    SettingTypeEnum::FILE->value,
                    SettingTypeEnum::VIDEO->value => [
                        SpatieMediaLibraryFileUpload::make('settings')
                            ->label('File')
                            ->collection('settings')
                            ->preserveFilenames()
                            ->multiple(false)
                            ->columnSpanFull(),
                    ],




                    // COLOR
                    SettingTypeEnum::COLOR->value => [
                        ColorPicker::make('value')->label('Value'),
                    ],

                    // URL
                    SettingTypeEnum::URL->value => [
                        TextInput::make('value')->label('Value')->url(),
                    ],

                    // DATE
                    SettingTypeEnum::DATE->value => [
                        DatePicker::make('value')->label('Value'),
                    ],

                    // DATETIME
                    SettingTypeEnum::DATETIME->value => [
                        DateTimePicker::make('value')->label('Value'),
                    ],


                    default => [],

                };
            });
    }
}
