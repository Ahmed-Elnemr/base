<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $recordTitleAttribute = 'date';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                DatePicker::make('date')
                    ->label(__('Date'))
                    ->required(),
                DateTimePicker::make('start_time')
                    ->label(__('Start Time')),
                DateTimePicker::make('end_time')
                    ->label(__('End Time')),
                TextInput::make('total_hours')
                    ->label(__('Total Hours'))
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'active' => __('Active'),
                        'completed' => __('Completed'),
                        'inactive' => __('Inactive'),
                    ])
                    ->required(),
                Textarea::make('achievement_report')
                    ->label(__('Achievement Report'))
                    ->columnSpanFull(),
                TextInput::make('deduction_value')
                    ->label(__('Deduction Value'))
                    ->numeric()
                    ->default(0.0),
                TextInput::make('deduction_reason')
                    ->label(__('Deduction Reason'))
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->label(__('Date'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_time')
                    ->label(__('Start Time'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label(__('End Time'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_hours')
                    ->label(__('Total Hours'))
                    ->numeric(2)
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'warning',
                        'completed' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'active' => __('Active'),
                        'completed' => __('Completed'),
                        'inactive' => __('Inactive'),
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
