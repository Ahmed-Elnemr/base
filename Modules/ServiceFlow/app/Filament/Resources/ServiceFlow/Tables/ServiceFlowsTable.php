<?php

namespace Modules\ServiceFlow\Filament\Resources\ServiceFlow\Tables;

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
use Modules\ServiceFlow\app\Models\ServiceFlow;

class ServiceFlowsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('step_image')
                    ->collection('step_image')
                    ->label(__('Image'))
                    ->square()
                    ->grow(false),
                Tables\Columns\TextColumn::make('step_number')
                    ->label(__('Step number'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn (ServiceFlow $record) => Str::limit(strip_tags($record->getTranslation('title', app()->getLocale())), 80))
                    ->wrap()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->since(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->modalWidth('3xl')
                    ->schema([
                        SchemaSection::make(__('Step details'))
                            ->columns(1)
                            ->schema([
                                SchemaImage::make(
                                    fn (ServiceFlow $record) => $record->getFirstMediaUrl('step_image') ?: 'https://via.placeholder.com/800x500/FEE2E2/1B1B18?text=ELMO5AFED',
                                    fn () => __('Step image')
                                )->imageHeight(220),
                                SchemaText::make(fn (ServiceFlow $record) => __('Step number') . ': ' . $record->step_number),
                                SchemaText::make(fn (ServiceFlow $record) => __('Title (Arabic)') . ': ' . strip_tags($record->getTranslation('title', 'ar'))),
                                SchemaText::make(fn (ServiceFlow $record) => __('Title (English)') . ': ' . strip_tags($record->getTranslation('title', 'en'))),
                                SchemaText::make(fn (ServiceFlow $record) => __('Description (Arabic)') . ': ' . strip_tags($record->getTranslation('description', 'ar')))->color('gray-600'),
                                SchemaText::make(fn (ServiceFlow $record) => __('Description (English)') . ': ' . strip_tags($record->getTranslation('description', 'en')))->color('gray-600'),
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

