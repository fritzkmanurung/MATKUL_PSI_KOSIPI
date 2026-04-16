<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas;

use App\Filament\Member\Resources\PenarikanAnggotas\Pages\CreatePenarikanAnggota;
use App\Filament\Member\Resources\PenarikanAnggotas\Pages\EditPenarikanAnggota;
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

    protected static ?string $modelLabel = 'Pengajuan Penarikan';
    protected static ?string $pluralModelLabel = 'Riwayat Pencairan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;
    protected static ?int $navigationSort = 3;

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
            'create' => CreatePenarikanAnggota::route('/create'),
            'view' => ViewPenarikanAnggota::route('/{record}'),
            'edit' => EditPenarikanAnggota::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }
}
