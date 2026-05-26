<?php

namespace App\Filament\Member\Resources\TagihanAnggotas;

use App\Filament\Member\Resources\TagihanAnggotas\Pages\CreateTagihanAnggota;
use App\Filament\Member\Resources\TagihanAnggotas\Pages\EditTagihanAnggota;
use App\Filament\Member\Resources\TagihanAnggotas\Pages\ListTagihanAnggotas;
use App\Filament\Member\Resources\TagihanAnggotas\Schemas\TagihanAnggotaForm;
use App\Filament\Member\Resources\TagihanAnggotas\Tables\TagihanAnggotasTable;
use Modules\Pinjaman\Models\TagihanPinjaman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagihanAnggotaResource extends Resource
{
    protected static ?string $model = TagihanPinjaman::class;

    protected static ?string $modelLabel = 'Tagihan Pinjaman';
    protected static ?string $pluralModelLabel = 'Tagihan Pinjaman';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('pinjaman', fn ($q) => $q->where('user_id', auth()->id()));
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Tagihan';

    public static function getNavigationGroup(): ?string
    {
        return 'Pinjaman';
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TagihanAnggotaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanAnggotasTable::configure($table);
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
            'index' => ListTagihanAnggotas::route('/'),
            'create' => CreateTagihanAnggota::route('/create'),
            'edit' => EditTagihanAnggota::route('/{record}/edit'),
        ];
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
        return in_array($record->status, ['Ditolak', 'Belum Dibayar']);
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
