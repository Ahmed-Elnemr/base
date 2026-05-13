<?php
namespace Modules\Slider\Filament\Resources\Slider;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Slider\app\Models\Slider;
use Modules\Slider\Filament\Resources\Slider\Pages\CreateSlider;
use Modules\Slider\Filament\Resources\Slider\Pages\EditSlider;
use Modules\Slider\Filament\Resources\Slider\Pages\ListSliders;
use Modules\Slider\Filament\Resources\Slider\Schemas\SliderForm;
use Modules\Slider\Filament\Resources\Slider\Tables\SlidersTable;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Slider');
    }

    public static function getModelLabel(): string
    {
        return __('Slider');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Sliders');
    }

    public static function form(Schema $schema): Schema
    {
        return SliderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SlidersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'edit'   => EditSlider::route('/{record}/edit'),
        ];
    }
}
