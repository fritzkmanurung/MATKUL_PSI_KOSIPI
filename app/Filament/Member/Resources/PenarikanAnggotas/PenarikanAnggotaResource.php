<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas;

use App\Filament\Member\Resources\PenarikanAnggotas\Pages\ListPenarikanAnggotas;
use App\Filament\Member\Resources\PenarikanAnggotas\Pages\ViewPenarikanAnggota;
use App\Filament\Member\Resources\PenarikanAnggotas\Schemas\PenarikanAnggotaForm;
use App\Filament\Member\Resources\PenarikanAnggotas\Schemas\PenarikanAnggotaInfolist;
use App\Filament\Member\Resources\PenarikanAnggotas\Tables\PenarikanAnggotasTable;
use Modules\Simpanan\Models\Penarikan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenarikanAnggotaResource extends Resource
{
    protected static ?string $model = Penarikan::class;

    protected static ?string $modelLabel = 'Penarikan Dana';
    protected static ?string $pluralModelLabel = 'Penarikan Dana';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Penarikan';

    public static function getNavigationGroup(): ?string
    {
        return 'Simpanan';
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PenarikanAnggotaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PenarikanAnggotaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenarikanAnggotasTable::configure($table);
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
            'index' => ListPenarikanAnggotas::route('/'),
            // 'create' => CreatePenarikanAnggota::route('/create'),
            // 'view' => ViewPenarikanAnggota::route('/{record}'),
            // 'edit' => EditPenarikanAnggota::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return in_array($record->status, ['Ditolak']);
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
