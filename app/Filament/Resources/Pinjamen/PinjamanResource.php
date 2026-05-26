<?php

namespace App\Filament\Resources\Pinjamen;

use App\Filament\Resources\Pinjamen\Pages\CreatePinjaman;
use App\Filament\Resources\Pinjamen\Pages\EditPinjaman;
use App\Filament\Resources\Pinjamen\Pages\ListPinjamen;
use App\Filament\Resources\Pinjamen\Pages\ViewPinjaman;
use App\Filament\Resources\Pinjamen\Schemas\PinjamanForm;
use App\Filament\Resources\Pinjamen\Schemas\PinjamanInfolist;
use App\Filament\Resources\Pinjamen\Tables\PinjamenTable;
use App\Filament\Resources\Pinjamen\PinjamanResource\Pages;
use Modules\Pinjaman\Models\Pinjaman;
use Filament\Forms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PinjamanResource extends Resource
{
    protected static ?string $model = Pinjaman::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Pinjaman';
    protected static \UnitEnum|string|null $navigationGroup = 'Pinjaman';
    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PinjamanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PinjamanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PinjamenTable::configure($table);
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
            'index' => ListPinjamen::route('/'),
            'create' => CreatePinjaman::route('/create'),
            'view' => ViewPinjaman::route('/{record}'),
            'edit' => EditPinjaman::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'tagihanPinjamans']);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canForceDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canForceDeleteAny(): bool
    {
        return false;
    }

    public static function canRestore(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canRestoreAny(): bool
    {
        return false;
    }
}
