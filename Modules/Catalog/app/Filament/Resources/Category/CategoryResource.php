<?php

namespace Modules\Catalog\Filament\Resources\Category;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Modules\Catalog\app\Models\Category;
use Modules\Catalog\Filament\Resources\Category\Pages\CreateCategory;
use Modules\Catalog\Filament\Resources\Category\Pages\EditCategory;
use Modules\Catalog\Filament\Resources\Category\Pages\ListCategories;
use Modules\Catalog\Filament\Resources\Category\Schemas\CategoryForm;
use Modules\Catalog\Filament\Resources\Category\Tables\CategoryTable;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('Category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Sections');
    }

    public static function getNavigationLabel(): string
    {
        return __('Sections');
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}

