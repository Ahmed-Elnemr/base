<?php

namespace Modules\About\Filament\Resources\AboutPage;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\About\app\Models\AboutPage;
use Modules\About\Filament\Resources\AboutPage\Pages\CreateAboutPage;
use Modules\About\Filament\Resources\AboutPage\Pages\EditAboutPage;
use Modules\About\Filament\Resources\AboutPage\Pages\ListAboutPages;
use Modules\About\Filament\Resources\AboutPage\Schemas\AboutPageForm;
use Modules\About\Filament\Resources\AboutPage\Tables\AboutPagesTable;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return static::getModel()::count() === 0;
    }

    public static function getNavigationLabel(): string
    {
        return __('من نحن');
    }

    public static function getModelLabel(): string
    {
        return __('محتوى');
    }

    public static function getPluralModelLabel(): string
    {
        return __('من نحن');
    }

    public static function form(Schema $schema): Schema
    {
        return AboutPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutPagesTable::configure($table);
    }

    public static function getNavigationUrl(): string
    {
        $record = static::getModel()::first();
        if ($record) {
            return static::getUrl('edit', ['record' => $record]);
        }

        return static::getUrl('create');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutPages::route('/'),
            'create' => CreateAboutPage::route('/create'),
            'edit' => EditAboutPage::route('/{record}/edit'),
        ];
    }
}
