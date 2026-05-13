<?php

namespace Modules\Catalog\Filament\Resources\Category\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Catalog\app\Models\Category;

class CategoryTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('category_image')
                    ->collection('category_image')
                    ->label(__('Image'))
                    ->square()
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->formatStateUsing(fn (Category $record) => $record->getTranslation('name', app()->getLocale()))
                    ->wrap()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Order'))
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}








