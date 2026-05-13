<?php

namespace Modules\Support\Filament\Resources\SupportMessage\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;

class SupportMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('full_name')
                        ->label(__('Full name'))
                        ->disabled()
                        ->columnSpanFull(),
                    TextInput::make('phone')
                        ->label(__('Phone'))
                        ->disabled(),
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->disabled(),
                    Select::make('message_type')
                        ->label(__('Message type'))
                        ->options(SupportMessageTypeEnum::options())
                        ->disabled()
                        ->columnSpanFull(),
                    Textarea::make('message')
                        ->label(__('Message'))
                        ->disabled()
                        ->rows(10)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label(__('Status'))
                        ->options(SupportMessageStatusEnum::options())
                        ->required(),
                    TextInput::make('locale')
                        ->label(__('Locale'))
                        ->disabled(),
                ]),
        ]);
    }
}
