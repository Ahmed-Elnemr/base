<?php
namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_image_url')
                    ->label(__('users.profile_image'))
                    ->circular()
                    ->height(40),

                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client_type')
                    ->label(__('users.client_type.label'))
                    ->badge()
                    ->formatStateUsing(fn($state) => $state === User::CLIENT_TYPE_COMPANY
                            ? __('users.client_type.company')
                            : __('users.client_type.customer'))
                    ->colors([
                        'success' => User::CLIENT_TYPE_CUSTOMER,
                        'warning' => User::CLIENT_TYPE_COMPANY,
                    ])
                    ->sortable(),

                TextColumn::make('phone')
                    ->label(__('users.phone'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->label(__('users.city'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),

                IconColumn::make('status')
                    ->label(__('Status'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()->label(__('Trashed')),
            ])
            ->recordActions([
                ViewAction::make()->label(__('View')),
                EditAction::make()->label(__('Edit')),
                DeleteAction::make()->label(__('Delete')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label(__('Delete Selected')),
                    ForceDeleteBulkAction::make()->label(__('Force Delete Selected')),
                    RestoreBulkAction::make()->label(__('Restore Selected')),
                ]),
            ]);
    }
}
