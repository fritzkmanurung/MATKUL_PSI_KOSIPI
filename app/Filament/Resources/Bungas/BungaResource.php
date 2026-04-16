<?php

namespace App\Filament\Resources\Bungas;

use App\Filament\Resources\Bungas\Pages\CreateBunga;
use App\Filament\Resources\Bungas\Pages\EditBunga;
use App\Filament\Resources\Bungas\Pages\ListBungas;
use App\Filament\Resources\Bungas\Pages\ViewBunga;
use App\Filament\Resources\Bungas\Schemas\BungaForm;
use App\Filament\Resources\Bungas\Schemas\BungaInfolist;
use App\Filament\Resources\Bungas\Tables\BungasTable;
use Modules\Sistem\Models\Bunga;
use Filament\Forms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BungaResource extends Resource
{
    protected static ?string $model = Bunga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?string $navigationLabel = 'Suku Bunga';
    protected static \UnitEnum|string|null $navigationGroup = 'Pinjaman';
    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return BungaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BungaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BungasTable::configure($table);
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
            'index' => ListBungas::route('/'),
            'create' => CreateBunga::route('/create'),
            'view' => ViewBunga::route('/{record}'),
            'edit' => EditBunga::route('/{record}/edit'),
        ];
    }
}
