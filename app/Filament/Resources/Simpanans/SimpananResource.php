<?php

namespace App\Filament\Resources\Simpanans;

use App\Filament\Resources\Simpanans\Pages\CreateSimpanan;
use App\Filament\Resources\Simpanans\Pages\EditSimpanan;
use App\Filament\Resources\Simpanans\Pages\ListSimpanans;
use App\Filament\Resources\Simpanans\Pages\ViewSimpanan;
use App\Filament\Resources\Simpanans\Schemas\SimpananForm;
use App\Filament\Resources\Simpanans\Schemas\SimpananInfolist;
use App\Filament\Resources\Simpanans\Tables\SimpanansTable;
use Modules\Simpanan\Models\Simpanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SimpananResource extends Resource
{
    protected static ?string $model = Simpanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SimpananForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SimpananInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SimpanansTable::configure($table);
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
            'index' => ListSimpanans::route('/'),
            'create' => CreateSimpanan::route('/create'),
            'view' => ViewSimpanan::route('/{record}'),
            'edit' => EditSimpanan::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
