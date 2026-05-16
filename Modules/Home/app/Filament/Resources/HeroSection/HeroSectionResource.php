<?php

namespace Modules\Home\Filament\Resources\HeroSection;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\HeroSection;
use Modules\Home\Filament\Resources\HeroSection\Pages\CreateHeroSection;
use Modules\Home\Filament\Resources\HeroSection\Pages\EditHeroSection;
use Modules\Home\Filament\Resources\HeroSection\Pages\ListHeroSections;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::PresentationChartLine;

    public static function getModelLabel(): string
    {
        return __('Hero Section');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Hero Sections');
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Home Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Hero Section');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(): string
    {
        $record = HeroSection::first();
        if ($record) {
            return static::getUrl('edit', ['record' => $record]);
        }
        return static::getUrl('index');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TranslatableTabs::make()
                    ->locales(['en', 'ar'])
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required(),
                        TextInput::make('subtitle')
                            ->label(__('Subtitle'))
                            ->required(),
                        TextInput::make('button_text_1')
                            ->label(__('Button Text 1'))
                            ->required(),
                        TextInput::make('button_text_2')
                            ->label(__('Button Text 2'))
                            ->required(),
                    ])->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('hero_image')
                    ->label(__('Hero Image'))
                    ->collection('hero_image')
                    ->required(),
                TextInput::make('button_url_1')
                    ->label(__('Button URL 1'))
                    ->url(),
                TextInput::make('button_url_2')
                    ->label(__('Button URL 2'))
                    ->url(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('hero_image')
                    ->label(__('Image'))
                    ->collection('hero_image'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                TextColumn::make('subtitle')
                    ->label(__('Subtitle'))
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroSections::route('/'),
            'create' => CreateHeroSection::route('/create'),
            'edit' => EditHeroSection::route('/{record}/edit'),
        ];
    }
}
