<?php

namespace Modules\Home\Filament\Resources\CTASection;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Home\app\Models\CTASection;
use Modules\Home\Filament\Resources\CTASection\Pages\CreateCTASection;
use Modules\Home\Filament\Resources\CTASection\Pages\EditCTASection;
use Modules\Home\Filament\Resources\CTASection\Pages\ListCTASections;

class CTASectionResource extends Resource
{
    protected static ?string $model = CTASection::class;

    protected static string|\BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::CursorArrowRays;

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('CTA Section');
    }

    public static function getPluralModelLabel(): string
    {
        return __('CTA Sections');
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
        $record = CTASection::first();
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
                        TextInput::make('button_text')
                            ->label(__('Button Text'))
                            ->required(),
                    ])->columnSpanFull(),
                TextInput::make('button_url')
                    ->label(__('Button URL'))
                    ->url(),
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
            'index' => ListCTASections::route('/'),
            'create' => CreateCTASection::route('/create'),
            'edit' => EditCTASection::route('/{record}/edit'),
        ];
    }
}
