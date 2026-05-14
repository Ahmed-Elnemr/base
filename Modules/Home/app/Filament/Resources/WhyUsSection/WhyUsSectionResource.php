<?php

namespace Modules\Home\Filament\Resources\WhyUsSection;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\WhyUsSection;
use Modules\Home\Filament\Resources\WhyUsSection\Pages\CreateWhyUsSection;
use Modules\Home\Filament\Resources\WhyUsSection\Pages\EditWhyUsSection;
use Modules\Home\Filament\Resources\WhyUsSection\Pages\ListWhyUsSections;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class WhyUsSectionResource extends Resource
{
    protected static ?string $model = WhyUsSection::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::QuestionMarkCircle;

    public static function getModelLabel(): string
    {
        return __('Why Us Section');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Why Us Sections');
    }

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Home Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Why Us Section');
    }

    public static function canCreate(): bool
    {
        return WhyUsSection::count() < 1;
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
                        RichEditor::make('content')
                            ->label(__('Content'))
                            ->required(),
                        Repeater::make('points')
                            ->label(__('Points'))
                            ->schema([
                                TextInput::make('text')->required(),
                            ])
                            ->columns(1),
                    ])->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('why_us_image')
                    ->label(__('Image'))
                    ->collection('why_us_image')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('why_us_image')
                    ->label(__('Image'))
                    ->collection('why_us_image'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
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
            'index' => ListWhyUsSections::route('/'),
            'create' => CreateWhyUsSection::route('/create'),
            'edit' => EditWhyUsSection::route('/{record}/edit'),
        ];
    }
}
