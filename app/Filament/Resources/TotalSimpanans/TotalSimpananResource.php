<?php

namespace App\Filament\Resources\TotalSimpanans;

use App\Filament\Resources\TotalSimpanans\Pages\CreateTotalSimpanan;
use App\Filament\Resources\TotalSimpanans\Pages\EditTotalSimpanan;
use App\Filament\Resources\TotalSimpanans\Pages\ListTotalSimpanans;
use App\Filament\Resources\TotalSimpanans\Pages\ViewTotalSimpanan;
use App\Filament\Resources\TotalSimpanans\Schemas\TotalSimpananForm;
use App\Filament\Resources\TotalSimpanans\Schemas\TotalSimpananInfolist;
use App\Filament\Resources\TotalSimpanans\Tables\TotalSimpanansTable;
use Modules\Simpanan\Models\TotalSimpanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TotalSimpananResource extends Resource
{
    public static function canCreate(): bool
    {
        return false;
    }

    protected static ?string $model = TotalSimpanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TotalSimpananForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TotalSimpananInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TotalSimpanansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTotalSimpanans::route('/'),
            'view' => ViewTotalSimpanan::route('/{record}'),
            'edit' => EditTotalSimpanan::route('/{record}/edit'),
        ];
    }
}
