<?php

namespace App\Filament\Resources\Penarikans;

use App\Filament\Resources\Penarikans\Pages\CreatePenarikan;
use App\Filament\Resources\Penarikans\Pages\EditPenarikan;
use App\Filament\Resources\Penarikans\Pages\ListPenarikans;
use App\Filament\Resources\Penarikans\Pages\ViewPenarikan;
use App\Filament\Resources\Penarikans\Schemas\PenarikanForm;
use App\Filament\Resources\Penarikans\Schemas\PenarikanInfolist;
use App\Filament\Resources\Penarikans\Tables\PenarikansTable;
use Modules\Simpanan\Models\Penarikan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenarikanResource extends Resource
{
    protected static ?string $model = Penarikan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static ?string $navigationLabel = 'Penarikan';
    protected static \UnitEnum|string|null $navigationGroup = 'Simpanan';
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PenarikanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PenarikanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenarikansTable::configure($table);
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
            'index' => ListPenarikans::route('/'),
            'create' => CreatePenarikan::route('/create'),
            'view' => ViewPenarikan::route('/{record}'),
            'edit' => EditPenarikan::route('/{record}/edit'),
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
