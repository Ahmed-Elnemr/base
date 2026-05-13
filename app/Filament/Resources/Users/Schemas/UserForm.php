<?php
namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Basic Information'))
                    ->schema([
                        Select::make('client_type')
                            ->label(__('users.client_type.label'))
                            ->options([
                                User::CLIENT_TYPE_CUSTOMER => __('users.client_type.customer'),
                                User::CLIENT_TYPE_COMPANY  => __('users.client_type.company'),
                            ])
                            ->default(User::CLIENT_TYPE_CUSTOMER)
                            ->required()
                            ->native(false)
                            ->live(),

                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('company_name')
                            ->label(__('users.company_name'))
                            ->maxLength(255)
                            ->visible(fn($get) => $get('client_type') === User::CLIENT_TYPE_COMPANY)
                            ->required(fn($get) => $get('client_type') === User::CLIENT_TYPE_COMPANY),

                        TextInput::make('phone')
                            ->label(__('users.phone'))
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->unique(table: User::class, column: 'phone', ignoreRecord: true),

                        TextInput::make('city')
                            ->label(__('users.city'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('Email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->revealable()
                            ->required(fn(string $operation) => $operation === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('users.company_section'))
                    ->schema([
                        TextInput::make('commercial_register')
                            ->label(__('users.commercial_register'))
                            ->maxLength(255)
                            ->required(fn($get) => $get('client_type') === User::CLIENT_TYPE_COMPANY),

                        Textarea::make('company_bio')
                            ->label(__('users.company_bio'))
                            ->columnSpanFull()
                            ->rows(4)
                            ->required(fn($get) => $get('client_type') === User::CLIENT_TYPE_COMPANY),
                    ])
                    ->columns(2)
                    ->hidden(fn($get) => $get('client_type') !== User::CLIENT_TYPE_COMPANY)
                    ->columnSpanFull(),

                Section::make(__('users.profile_section'))
                    ->schema([
                        FileUpload::make('profile_image_path')
                            ->label(__('users.profile_image'))
                            ->image()
                            ->directory('users')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->imagePreviewHeight('150'),

                        Toggle::make('status')
                            ->label(__('Status'))
                            ->default(true),
                        DateTimePicker::make('terms_accepted_at')
                            ->label(__('users.terms_accepted_at'))
                            ->seconds(false)
                            ->native(false)
                            ->helperText(__('users.terms_accepted_hint')),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
