<?php

namespace Modules\Support\Filament\Resources\SupportMessage\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Section as SchemaSection;
use Filament\Schemas\Components\Text as SchemaText;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;
use Modules\Support\app\Models\SupportMessage;

class SupportMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('Full name'))
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('message_type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn ($state) => ($state instanceof SupportMessageTypeEnum)
                            ? $state->label()
                            : SupportMessageTypeEnum::from($state)->label())
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof SupportMessageTypeEnum ? $state->value : $state) {
                        'complaint' => 'warning',
                        'suggestion' => 'success',
                        'other' => 'gray',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->formatStateUsing(fn ($state) => ($state instanceof SupportMessageStatusEnum)
                            ? $state->label()
                            : SupportMessageStatusEnum::from($state)->label())
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof SupportMessageStatusEnum ? $state->value : $state) {
                        'new' => 'primary',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('Locale'))
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('message')
                    ->label(__('Message'))
                    ->formatStateUsing(fn (?string $state) => $state ? Str::limit($state, 40) : null)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Received at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(SupportMessageStatusEnum::options()),
                Tables\Filters\SelectFilter::make('message_type')
                    ->options(SupportMessageTypeEnum::options()),
                Tables\Filters\SelectFilter::make('locale')
                    ->options([
                        'ar' => 'ar',
                        'en' => 'en',
                    ]),
            ])
            ->headerActions([])
            ->actions([
                ViewAction::make()
                    ->schema([
                        SchemaSection::make(__('Message details'))
                            ->columns(1)
                            ->schema([
                                SchemaText::make(fn (SupportMessage $record) => __('Full name').': '.$record->full_name),
                                SchemaText::make(fn (SupportMessage $record) => __('Phone').': '.($record->phone ?: '-')),
                                SchemaText::make(fn (SupportMessage $record) => __('Email').': '.($record->email ?: '-')),
                                SchemaText::make(fn (SupportMessage $record) => __('Message type').': '.$record->message_type->label()),
                                SchemaText::make(fn (SupportMessage $record) => __('Status').': '.$record->status->label()),
                                SchemaText::make(fn (SupportMessage $record) => __('Locale').': '.$record->locale),
                                SchemaText::make(fn (SupportMessage $record) => __('Received at').': '.optional($record->created_at)->toDateTimeString()),
                                SchemaText::make(fn (SupportMessage $record) => __('Message').': '.$record->message)->color('gray-600'),
                            ]),
                    ]),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
