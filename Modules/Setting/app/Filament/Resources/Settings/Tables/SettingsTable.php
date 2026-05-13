<?php

namespace Modules\Setting\Filament\Resources\Settings\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\SettingTypeEnum;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn(SettingTypeEnum $state) => $state->label())
                    ->color(fn (SettingTypeEnum $state): string => match ($state) {
                        SettingTypeEnum::SHORT_TEXT => 'gray',
                        SettingTypeEnum::LONG_TEXT => 'blue',
                        SettingTypeEnum::RICH_TEXT => 'indigo',
                        SettingTypeEnum::INTEGER => 'green',
                        SettingTypeEnum::DECIMAL => 'teal',
                        SettingTypeEnum::BOOLEAN => 'orange',
                        SettingTypeEnum::IMAGE => 'purple',
                        SettingTypeEnum::FILE => 'cyan',
                        SettingTypeEnum::VIDEO => 'pink',
                        SettingTypeEnum::URL => 'yellow',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_translatable')
                    ->label('Translatable')
                    ->boolean()
                    ->trueIcon('heroicon-o-language')
                    ->falseIcon('heroicon-o-x-mark'),
//
//                Tables\Columns\TextColumn::make('value')
//                    ->label('Value')
//                    ->toggleable()
//                    ->formatStateUsing(function ($record) {
//                        // BOOLEAN
//                        if ($record->type === SettingTypeEnum::BOOLEAN) {
//                            return $record->value ? __('Yes') : __('No');
//                        }
//
//                        // IMAGE
//                        if ($record->type === SettingTypeEnum::IMAGE) {
//                            $url = $record->value;
//                            return $url
//                                ? '<img src="'.asset($url).'" alt="image" class="h-10 w-10 object-cover rounded" />'
//                                : __('No Image');
//                        }
//
//                        // FILE
//                        if ($record->type === SettingTypeEnum::FILE) {
//                            $url = $record->value;
//                            return $url
//                                ? '<a href="'.asset($url).'" target="_blank">'.__('Download File').'</a>'
//                                : __('No File');
//                        }
//
//                        // VIDEO
//                        if ($record->type === SettingTypeEnum::VIDEO) {
//                            $url = $record->value;
//                            return $url
//                                ? '<video class="h-16" controls><source src="'.asset($url).'" type="video/mp4">Your browser does not support the video tag.</video>'
//                                : __('No Video');
//                        }
//
//                        // COLOR
//                        if ($record->type === SettingTypeEnum::COLOR) {
//                            $color = $record->value;
//                            return $color
//                                ? '<div style="width:40px;height:20px;background-color:'.$color.';border:1px solid #ccc;"></div>'
//                                : __('No Color');
//                        }
//
//                        // TRANSLATABLE
//                        if ($record->is_translatable) {
//                            $values = $record->value ?? [];
//                            if (is_string($values)) {
//                                $values = json_decode($values, true) ?? [];
//                            }
//                            $localeValue = $values[app()->getLocale()] ?? 'N/A';
//                            return is_string($localeValue) ? substr($localeValue, 0, 40) : 'N/A';
//                        }
//
//                        // DEFAULT: string or array
//                        if (is_array($record->value)) {
//                            return json_encode($record->value);
//                        }
//
//                        return substr((string)$record->value, 0, 40);
//                    })
//                    ->html()
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(function () {
                        return collect(SettingTypeEnum::cases())->mapWithKeys(function ($case) {
                            return [$case->value => $case->name];
                        })->toArray();
                    }),

                Tables\Filters\TernaryFilter::make('is_translatable')
                    ->label('Translatable'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }

    private static function formatValue($record): string
    {
        // BOOLEAN
        if ($record->type === SettingTypeEnum::BOOLEAN) {
            return $record->value ? 'Yes' : 'No';
        }

        // MEDIA TYPES
        if (in_array($record->type, [
            SettingTypeEnum::IMAGE,
            SettingTypeEnum::FILE,
            SettingTypeEnum::VIDEO,
        ])) {
            return $record->getFirstMediaUrl('settings') ? 'File Uploaded' : 'No File';
        }


        // TRANSLATABLE
        if ($record->is_translatable) {
            $values = $record->value ?? [];

            if (is_string($values)) {
                $values = json_decode($values, true) ?? [];
            }

            $localeValue = $values[app()->getLocale()] ?? 'N/A';

            return is_string($localeValue) ? substr($localeValue, 0, 40) : 'N/A';
        }

        // DEFAULT: value is string or array
        if (is_array($record->value)) {
            return json_encode($record->value);
        }

        return substr((string) $record->value, 0, 40);
    }

}
