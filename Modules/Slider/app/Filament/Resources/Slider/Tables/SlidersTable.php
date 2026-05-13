<?php
namespace Modules\Slider\Filament\Resources\Slider\Tables;

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
use Modules\Slider\app\Models\Slider;

class SlidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('slider_cover')
                    ->label(__('Image'))
                    ->collection('slider_cover')
                    ->square()
                    ->grow(false),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn(Slider $record) => Str::limit(strip_tags($record->getTranslation('title', app()->getLocale())), 60))
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Order'))
                    ->sortable()
                    ->grow(false),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('Active')),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->label(__('Published at'))
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Is active')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->modalWidth('4xl')
                    ->schema([
                        SchemaSection::make(__('Slider content'))
                            ->columns(1)
                            ->schema([
                                SchemaImage::make(
                                    fn(Slider $record) => $record->getFirstMediaUrl('slider_cover') ?: 'https://via.placeholder.com/800x480/FFE8C9/1B1B18?text=ELMO5AFED',
                                    fn(Slider $record) => $record->getTranslation('title', app()->getLocale()) ?: 'Slide'
                                )->imageHeight(240),
                                SchemaText::make(fn(Slider $record) => __('Title (Arabic)') . ': ' . strip_tags($record->getTranslation('title', 'ar')))
                                    ->weight('semibold')
                                    ->color('gray-900'),
                                SchemaText::make(fn(Slider $record) => __('Title (English)') . ': ' . strip_tags($record->getTranslation('title', 'en')))
                                    ->color('gray-700'),
                                SchemaText::make(fn(Slider $record) => __('Description (Arabic)') . ': ' . strip_tags($record->getTranslation('description', 'ar')))
                                    ->color('gray-600'),
                                SchemaText::make(fn(Slider $record) => __('Description (English)') . ': ' . strip_tags($record->getTranslation('description', 'en')))
                                    ->color('gray-600'),
                            ]),
                        SchemaSection::make(__('Publishing'))
                            ->columns(2)
                            ->schema([
                                SchemaText::make(fn(Slider $record) => __('Active') . ': ' . ($record->is_active ? __('Yes') : __('No')))
                                    ->weight('semibold'),
                                SchemaText::make(fn(Slider $record) => __('Sort order') . ': ' . $record->sort_order),
                                SchemaText::make(fn(Slider $record) => __('Published at') . ': ' . optional($record->published_at)->translatedFormat('Y-m-d h:i A')),
                                SchemaText::make(fn(Slider $record) => __('Last update') . ': ' . optional($record->updated_at)->diffForHumans()),
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
