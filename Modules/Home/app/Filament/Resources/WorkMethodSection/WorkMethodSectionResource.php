<?php

namespace Modules\Home\Filament\Resources\WorkMethodSection;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\WorkMethodSection;
use Modules\Home\Filament\Resources\WorkMethodSection\Pages\CreateWorkMethodSection;
use Modules\Home\Filament\Resources\WorkMethodSection\Pages\EditWorkMethodSection;
use Modules\Home\Filament\Resources\WorkMethodSection\Pages\ListWorkMethodSections;

class WorkMethodSectionResource extends Resource
{
    protected static ?string $model = WorkMethodSection::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::QueueList;

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Work Method Section');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Work Method Sections');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Home Management');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(): string
    {
        $record = WorkMethodSection::first();
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
                        Repeater::make('steps')
                            ->label(__('Steps'))
                            ->schema([
                                TextInput::make('number')
                                    ->label(__('Number'))
                                    ->placeholder('e.g. 01')
                                    ->required(),
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required(),
                                TextInput::make('description')
                                    ->label(__('Description'))
                                    ->required(),
                            ])
                            ->columns(1),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => ListWorkMethodSections::route('/'),
            'create' => CreateWorkMethodSection::route('/create'),
            'edit' => EditWorkMethodSection::route('/{record}/edit'),
        ];
    }
}
