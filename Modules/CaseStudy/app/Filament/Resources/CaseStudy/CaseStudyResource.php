<?php

namespace Modules\CaseStudy\Filament\Resources\CaseStudy;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\CaseStudy\app\Models\CaseStudy;
use Modules\CaseStudy\Filament\Resources\CaseStudy\Pages\CreateCaseStudy;
use Modules\CaseStudy\Filament\Resources\CaseStudy\Pages\EditCaseStudy;
use Modules\CaseStudy\Filament\Resources\CaseStudy\Pages\ListCaseStudies;
use Modules\CaseStudy\Filament\Resources\CaseStudy\Schemas\CaseStudyForm;
use Modules\CaseStudy\Filament\Resources\CaseStudy\Tables\CaseStudiesTable;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('دراسات الحالة');
    }

    public static function getModelLabel(): string
    {
        return __('دراسة حالة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('دراسات الحالة');
    }

    public static function form(Schema $schema): Schema
    {
        return CaseStudyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaseStudiesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCaseStudies::route('/'),
            'create' => CreateCaseStudy::route('/create'),
            'edit' => EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
