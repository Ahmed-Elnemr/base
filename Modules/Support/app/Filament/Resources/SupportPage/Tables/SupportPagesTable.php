<?php

namespace Modules\Support\Filament\Resources\SupportPage\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Image as SchemaImage;
use Filament\Schemas\Components\Section as SchemaSection;
use Filament\Schemas\Components\Text as SchemaText;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Support\app\Models\SupportPage;

class SupportPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn (SupportPage $record) => Str::limit(strip_tags($record->getTranslation('title', app()->getLocale())), 80))
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->schema([
                        SchemaSection::make(__('Support content'))
                            ->columns(1)
                            ->schema([
                                SchemaImage::make(
                                    fn (SupportPage $record) => $record->getFirstMediaUrl('support_image') ?: 'https://via.placeholder.com/800x500/FFE4E6/1B1B18?text=ELMO5AFED',
                                    fn () => __('Visual')
                                )->imageHeight(220),
                                SchemaText::make(fn (SupportPage $record) => __('Title (Arabic)') . ': ' . strip_tags($record->getTranslation('title', 'ar'))),
                                SchemaText::make(fn (SupportPage $record) => __('Title (English)') . ': ' . strip_tags($record->getTranslation('title', 'en'))),
                                SchemaText::make(fn (SupportPage $record) => __('Description (Arabic)') . ': ' . strip_tags($record->getTranslation('description', 'ar')))->color('gray-600'),
                                SchemaText::make(fn (SupportPage $record) => __('Description (English)') . ': ' . strip_tags($record->getTranslation('description', 'en')))->color('gray-600'),
                            ]),
                        SchemaSection::make(__('Status'))
                            ->columns(2)
                            ->schema([
                                SchemaText::make(fn (SupportPage $record) => __('Active') . ': ' . ($record->is_active ? __('Yes') : __('No'))),
                                SchemaText::make(fn (SupportPage $record) => __('Last update') . ': ' . optional($record->updated_at)->diffForHumans()),
                            ]),
                    ]),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}

