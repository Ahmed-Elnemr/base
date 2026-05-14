<?php

namespace Modules\About\Filament\Resources\AboutPage\Tables;

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
use Modules\About\app\Models\AboutPage;

class AboutPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('about_image')
                    ->label(__('Image'))
                    ->collection('about_image')
                    ->square()
                    ->grow(false),
                Tables\Columns\TextColumn::make('sub_title')
                    ->label(__('Sub Title'))
                    ->formatStateUsing(fn (AboutPage $record) => Str::limit(strip_tags($record->getTranslation('sub_title', app()->getLocale())), 50))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn (AboutPage $record) => Str::limit(strip_tags($record->getTranslation('title', app()->getLocale())), 50))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->label(__('Updated at')),
            ])
            ->headerActions([
            ])
            ->actions([
                ViewAction::make()
                    ->modalWidth('4xl')
                    ->schema([
                        SchemaSection::make(__('Page content'))
                            ->columns(1)
                            ->schema([
                                SchemaImage::make(
                                    fn (AboutPage $record) => $record->getFirstMediaUrl('about_image') ?: 'https://via.placeholder.com/800x500/FEE2E2/1B1B18?text=PURPLE',
                                    fn () => __('Primary image')
                                )->imageHeight(220),
                                SchemaText::make(fn (AboutPage $record) => __('Sub Title (Arabic)') . ': ' . strip_tags($record->getTranslation('sub_title', 'ar'))),
                                SchemaText::make(fn (AboutPage $record) => __('Sub Title (English)') . ': ' . strip_tags($record->getTranslation('sub_title', 'en'))),
                                SchemaText::make(fn (AboutPage $record) => __('Title (Arabic)') . ': ' . strip_tags($record->getTranslation('title', 'ar'))),
                                SchemaText::make(fn (AboutPage $record) => __('Title (English)') . ': ' . strip_tags($record->getTranslation('title', 'en'))),
                                SchemaText::make(fn (AboutPage $record) => __('Description (Arabic)') . ': ' . Str::limit(strip_tags($record->getTranslation('description', 'ar')), 200))->color('gray-600'),
                                SchemaText::make(fn (AboutPage $record) => __('Description (English)') . ': ' . Str::limit(strip_tags($record->getTranslation('description', 'en')), 200))->color('gray-600'),
                            ]),
                        SchemaSection::make(__('Status'))
                            ->columns(2)
                            ->schema([
                                SchemaText::make(fn (AboutPage $record) => __('Active') . ': ' . ($record->is_active ? __('Yes') : __('No'))),
                                SchemaText::make(fn (AboutPage $record) => __('Last update') . ': ' . optional($record->updated_at)->diffForHumans()),
                            ]),
                    ]),
                EditAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}

