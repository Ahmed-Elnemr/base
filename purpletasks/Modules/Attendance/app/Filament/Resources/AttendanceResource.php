<?php

namespace Modules\Attendance\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Attendance\app\Models\Attendance;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Calendar;

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Attendance');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Attendances');
    }

    public static function getNavigationLabel(): string
    {
        return __('Attendances');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Attendances Management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label(__('Date'))
                    ->date()
                    ->sortable(),
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
                TextColumn::make('deduction_value')
                    ->label(__('Deduction Value'))
                    ->numeric(2)
                    ->sortable(),
                TextColumn::make('deduction_reason')
                    ->label(__('Deduction Reason'))
                    ->searchable(),
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
                SelectFilter::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'active' => __('Active'),
                        'completed' => __('Completed'),
                        'inactive' => __('Inactive'),
                    ]),
                Filter::make('date')
                    ->form([
                        DatePicker::make('created_from')->label(__('From Date')),
                        DatePicker::make('created_until')->label(__('To Date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Modules\Attendance\Filament\Resources\AttendanceResource\Pages\ListAttendances::route('/'),
            'create' => \Modules\Attendance\Filament\Resources\AttendanceResource\Pages\CreateAttendance::route('/create'),
            'edit' => \Modules\Attendance\Filament\Resources\AttendanceResource\Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
