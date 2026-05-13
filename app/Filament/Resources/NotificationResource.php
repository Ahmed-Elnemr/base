<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class NotificationResource extends Resource
{
    protected static ?string $model = \Illuminate\Notifications\DatabaseNotification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bell;

    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Notifications');
    }

    public static function getModelLabel(): string
    {
        return __('Notification');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Notifications');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Recipients Selection'))
                    ->description(__('Choose who will receive this notification'))
                    ->schema([
                        Checkbox::make('send_to_all')
                            ->label(__('Send to all users'))
                            ->default(false)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('users', null);
                                }
                            }),

                        Select::make('users')
                            ->label(__('Select Recipients'))
                            ->options(User::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                            ->hidden(fn (callable $get): bool => $get('send_to_all'))
                            ->disabled(fn (callable $get): bool => $get('send_to_all'))
                            ->required(fn (callable $get): bool => !$get('send_to_all'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if (!empty($state)) {
                                    $set('send_to_all', false);
                                }
                            }),
                    ])->columns(1),

                Section::make(__('Notification Content'))
                    ->description(__('Write your notification message in both languages'))
                    ->schema([
                        Tabs::make('Labels')
                            ->tabs([
                                Tabs\Tab::make(__('arabic'))
                                    ->schema([
                                        TextInput::make('title_ar')
                                            ->label(__('Title'))
                                            ->required(),
                                        Textarea::make('body_ar')
                                            ->label(__('Body'))
                                            ->required()
                                            ->rows(3),
                                    ]),
                                Tabs\Tab::make(__('english'))
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->label(__('Title'))
                                            ->required(),
                                        Textarea::make('body_en')
                                            ->label(__('Body'))
                                            ->required()
                                            ->rows(3),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('notifiable.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('data.title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn ($state) => $state[app()->getLocale()] ?? $state['ar'] ?? $state['en'] ?? '')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('data.body')
                    ->label(__('Body'))
                    ->formatStateUsing(fn ($state) => $state[app()->getLocale()] ?? $state['ar'] ?? $state['en'] ?? '')
                    ->searchable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
        ];
    }
}
