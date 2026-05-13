<?php

namespace Modules\Support\Filament\Resources\SupportMessage;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Modules\Support\app\Models\SupportMessage;
use Modules\Support\Filament\Resources\SupportMessage\Pages\EditSupportMessage;
use Modules\Support\Filament\Resources\SupportMessage\Pages\ListSupportMessages;
use Modules\Support\Filament\Resources\SupportMessage\Schemas\SupportMessageForm;
use Modules\Support\Filament\Resources\SupportMessage\Tables\SupportMessagesTable;

class SupportMessageResource extends Resource
{
    protected static ?string $model = SupportMessage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 6;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __('Support messages');
    }

    public static function getModelLabel(): string
    {
        return __('Support message');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Support messages');
    }

    public static function form(Schema $schema): Schema
    {
        return SupportMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupportMessagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupportMessages::route('/'),
            'edit' => EditSupportMessage::route('/{record}/edit'),
        ];
    }
}
