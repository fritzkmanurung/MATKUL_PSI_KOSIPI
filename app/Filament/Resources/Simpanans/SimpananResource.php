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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;

    protected static ?string $navigationLabel = 'Mutasi';
    protected static ?string $modelLabel = 'Mutasi Simpanan';
    protected static ?string $pluralModelLabel = 'Mutasi Simpanan';
    protected static \UnitEnum|string|null $navigationGroup = 'Simpanan';
    protected static ?int $navigationSort = 2;

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user']);
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
