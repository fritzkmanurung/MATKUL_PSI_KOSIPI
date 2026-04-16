<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas;

use App\Filament\Member\Resources\PinjamanAnggotas\Pages\CreatePinjamanAnggota;
use App\Filament\Member\Resources\PinjamanAnggotas\Pages\EditPinjamanAnggota;
use App\Filament\Member\Resources\PinjamanAnggotas\Pages\ListPinjamanAnggotas;
use App\Filament\Member\Resources\PinjamanAnggotas\Pages\ViewPinjamanAnggota;
use App\Filament\Member\Resources\PinjamanAnggotas\Schemas\PinjamanAnggotaForm;
use App\Filament\Member\Resources\PinjamanAnggotas\Schemas\PinjamanAnggotaInfolist;
use App\Filament\Member\Resources\PinjamanAnggotas\Tables\PinjamanAnggotasTable;
use Modules\Pinjaman\Models\Pinjaman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PinjamanAnggotaResource extends Resource
{
    protected static ?string $model = Pinjaman::class;

    protected static ?string $modelLabel = 'Pengajuan Kredit/Pinjaman';
    protected static ?string $pluralModelLabel = 'Pinjaman Saya';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PinjamanAnggotaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PinjamanAnggotaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PinjamanAnggotasTable::configure($table);
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
            'index' => ListPinjamanAnggotas::route('/'),
            'create' => CreatePinjamanAnggota::route('/create'),
            'view' => ViewPinjamanAnggota::route('/{record}'),
            'edit' => EditPinjamanAnggota::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }
}
