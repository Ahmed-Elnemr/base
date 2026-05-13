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
                Tables\Columns\TextColumn::make('intro')
                    ->label(__('Intro'))
                    ->formatStateUsing(fn (AboutPage $record) => Str::limit(strip_tags($record->getTranslation('intro', app()->getLocale())), 80))
                    ->wrap()
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
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->modalWidth('4xl')
                    ->schema([
                        SchemaSection::make(__('Page content'))
                            ->columns(1)
                            ->schema([
                                SchemaImage::make(
                                    fn (AboutPage $record) => $record->getFirstMediaUrl('about_image') ?: 'https://via.placeholder.com/800x500/FEE2E2/1B1B18?text=ELMO5AFED',
                                    fn () => __('Primary image')
                                )->imageHeight(220),
                                SchemaText::make(fn (AboutPage $record) => __('Intro (Arabic)') . ': ' . strip_tags($record->getTranslation('intro', 'ar'))),
                                SchemaText::make(fn (AboutPage $record) => __('Intro (English)') . ': ' . strip_tags($record->getTranslation('intro', 'en'))),
                                SchemaText::make(fn (AboutPage $record) => __('Content (Arabic)') . ': ' . strip_tags($record->getTranslation('content', 'ar')))->color('gray-600'),
                                SchemaText::make(fn (AboutPage $record) => __('Content (English)') . ': ' . strip_tags($record->getTranslation('content', 'en')))->color('gray-600'),
                            ]),
                        SchemaSection::make(__('Status'))
                            ->columns(2)
                            ->schema([
                                SchemaText::make(fn (AboutPage $record) => __('Active') . ': ' . ($record->is_active ? __('Yes') : __('No'))),
                                SchemaText::make(fn (AboutPage $record) => __('Last update') . ': ' . optional($record->updated_at)->diffForHumans()),
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

