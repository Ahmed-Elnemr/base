<?php

namespace Modules\Project\Filament\Resources\ProjectRequest;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Project\app\Models\ProjectRequest;

class ProjectRequestResource extends Resource
{
    protected static ?string $model = ProjectRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('User Inquiries');
    }

    public static function getNavigationLabel(): string
    {
        return __('Project Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Request');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Project Requests');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->disabled(),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->required()
                    ->disabled(),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->required()
                    ->disabled(),
                Select::make('service_id')
                    ->label(__('Service'))
                    ->relationship('service', 'title')
                    ->disabled(),
                TextInput::make('company')
                    ->label(__('Company'))
                    ->disabled(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->disabled(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pending' => __('Pending'),
                        'contacted' => __('Contacted'),
                        'completed' => __('Completed'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable(),
                TextColumn::make('service.title')
                    ->label(__('Service')),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => __('Pending'),
                        'contacted' => __('Contacted'),
                        'completed' => __('Completed'),
                        'cancelled' => __('Cancelled'),
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'contacted' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectRequests::route('/'),
            'edit' => Pages\EditProjectRequest::route('/{record}/edit'),
        ];
    }
}
