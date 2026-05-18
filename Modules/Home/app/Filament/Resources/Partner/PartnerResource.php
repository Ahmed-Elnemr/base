<?php

namespace Modules\Home\Filament\Resources\Partner;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\Partner;
use Modules\Home\Filament\Resources\Partner\Pages\CreatePartner;
use Modules\Home\Filament\Resources\Partner\Pages\EditPartner;
use Modules\Home\Filament\Resources\Partner\Pages\ListPartners;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::UserGroup;

    public static function getModelLabel(): string
    {
        return __('Partner');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Partners');
    }

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('Home Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Partners');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                SpatieMediaLibraryFileUpload::make('logo')
                    ->label(__('Logo'))
                    ->collection('logo')
                    ->disk('public')
                    ->image()
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
                TextInput::make('sort_order')
                    ->label(__('Sort Order'))
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->label(__('Logo'))
                    ->collection('logo'),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label(__('Sort Order'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}
