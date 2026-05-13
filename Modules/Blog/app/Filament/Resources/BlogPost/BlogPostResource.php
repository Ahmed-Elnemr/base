<?php

namespace Modules\Blog\Filament\Resources\BlogPost;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Blog\app\Models\BlogPost;
use Modules\Blog\Filament\Resources\BlogPost\Pages\CreateBlogPost;
use Modules\Blog\Filament\Resources\BlogPost\Pages\EditBlogPost;
use Modules\Blog\Filament\Resources\BlogPost\Pages\ListBlogPosts;
use Modules\Blog\Filament\Resources\BlogPost\Schemas\BlogPostForm;
use Modules\Blog\Filament\Resources\BlogPost\Tables\BlogPostsTable;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return __('Blog Post');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blog Posts');
    }

    public static function getNavigationLabel(): string
    {
        return __('Blog Posts');
    }

    public static function form(Schema $schema): Schema
    {
        return BlogPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogPostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogPosts::route('/'),
            'create' => CreateBlogPost::route('/create'),
            'edit' => EditBlogPost::route('/{record}/edit'),
        ];
    }
}
