<?php

namespace Modules\Support\Filament\Resources\SupportPage\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()
                ->columns(1)
                ->schema([
                    TextInput::make('full_name')
                        ->label(__('Full name'))
                        ->disabled()
                        ->columnSpanFull(),
                    TextInput::make('phone')
                        ->label(__('Phone'))
                        ->disabled()
                        ->columnSpanFull(),
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->disabled()
                        ->columnSpanFull(),
                    Select::make('message_type')
                        ->label(__('Message type'))
                        ->options(SupportMessageTypeEnum::options())
                        ->disabled()
                        ->columnSpanFull(),
                    Textarea::make('message')
                        ->label(__('Message'))
                        ->disabled()
                        ->rows(6)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label(__('Status'))
                        ->options(SupportMessageStatusEnum::options())
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('Full name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone')),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email')),
                Tables\Columns\TextColumn::make('message_type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn ($state) => SupportMessageTypeEnum::from($state)->label())
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'complaint' => 'warning',
                        'suggestion' => 'success',
                        'other' => 'gray',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->formatStateUsing(fn ($state) => SupportMessageStatusEnum::from($state)->label())
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('Received at')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(SupportMessageStatusEnum::options()),
                Tables\Filters\SelectFilter::make('message_type')
                    ->options(SupportMessageTypeEnum::options()),
            ])
            ->headerActions([])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}

