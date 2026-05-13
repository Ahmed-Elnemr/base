<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Basic Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),

                        TextEntry::make('email')
                            ->label(__('Email')),

                        IconEntry::make('status')
                            ->label(__('Status'))
                            ->boolean(),

                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime(),
                    ])->columns(2),

                Section::make(__('Roles & Permissions'))
                    ->schema([
                        RepeatableEntry::make('roles')
                            ->label(__('Roles'))
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Role Name')),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }
}
