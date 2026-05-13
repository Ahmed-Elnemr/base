<?php
namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Basic Information'))
                    ->schema([
                        ImageEntry::make('profile_image_url')
                            ->label(__('users.profile_image'))
                            ->circular()
                            ->height('120')
                            ->visible(fn($record) => filled($record?->profile_image_url)),

                        TextEntry::make('name')
                            ->label(__('Name')),

                        TextEntry::make('client_type')
                            ->label(__('users.client_type.label'))
                            ->badge()
                            ->color(fn($state) => $state === User::CLIENT_TYPE_COMPANY ? 'warning' : 'success')
                            ->formatStateUsing(fn($state) => $state === User::CLIENT_TYPE_COMPANY
                                    ? __('users.client_type.company')
                                    : __('users.client_type.customer')),

                        TextEntry::make('phone')
                            ->label(__('users.phone')),

                        TextEntry::make('city')
                            ->label(__('users.city')),

                        TextEntry::make('email')
                            ->label(__('Email')),

                        IconEntry::make('status')
                            ->label(__('Status'))
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),

                        IconEntry::make('email_verified_at')
                            ->label(__('Email Verified'))
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),

                        TextEntry::make('terms_accepted_at')
                            ->label(__('users.terms_accepted_at'))
                            ->dateTime()
                            ->placeholder('—'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('users.company_section'))
                    ->schema([
                        TextEntry::make('company_name')
                            ->label(__('users.company_name'))
                            ->visible(fn($record) => $record?->client_type === User::CLIENT_TYPE_COMPANY),

                        TextEntry::make('commercial_register')
                            ->label(__('users.commercial_register'))
                            ->visible(fn($record) => $record?->client_type === User::CLIENT_TYPE_COMPANY),

                        TextEntry::make('company_bio')
                            ->label(__('users.company_bio'))
                            ->columnSpanFull()
                            ->visible(fn($record) => $record?->client_type === User::CLIENT_TYPE_COMPANY),
                    ])
                    ->visible(fn($record) => $record?->client_type === User::CLIENT_TYPE_COMPANY)
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('Metadata'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label(__('Updated at'))
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
