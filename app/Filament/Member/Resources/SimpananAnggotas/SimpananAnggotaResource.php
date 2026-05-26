<?php

namespace App\Filament\Member\Resources\SimpananAnggotas;

use App\Filament\Member\Resources\SimpananAnggotas\Pages\ListSimpananAnggotas;
use App\Filament\Member\Resources\SimpananAnggotas\Pages\ViewSimpananAnggota;
use App\Filament\Member\Resources\SimpananAnggotas\Schemas\SimpananAnggotaForm;
use App\Filament\Member\Resources\SimpananAnggotas\Schemas\SimpananAnggotaInfolist;
use App\Filament\Member\Resources\SimpananAnggotas\Tables\SimpananAnggotasTable;
use Modules\Simpanan\Models\Simpanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SimpananAnggotaResource extends Resource
{
    protected static ?string $model = Simpanan::class;

    protected static ?string $modelLabel = 'Data Simpanan';
    protected static ?string $pluralModelLabel = 'Data Simpanan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Simpanan';

    public static function getNavigationGroup(): ?string
    {
        return 'Simpanan';
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SimpananAnggotaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SimpananAnggotaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SimpananAnggotasTable::configure($table);
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
            'index' => ListSimpananAnggotas::route('/'),
            // 'create' => CreateSimpananAnggota::route('/create'),
            // 'edit' => EditSimpananAnggota::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return in_array($record->status, ['Menunggu', 'Revisi', 'Ditolak']);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return $record->status === 'Menunggu';
    }

    public static function canDeleteAny(): bool
    {
        return true;
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
