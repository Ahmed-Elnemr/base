<?php

namespace Modules\Faq\Filament\Resources\FaqSection\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Faq\app\Models\FaqSection;

class FaqSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn (FaqSection $record) => Str::limit(strip_tags($record->getTranslation('title', app()->getLocale())), 80))
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->label(__('Updated at')),
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

